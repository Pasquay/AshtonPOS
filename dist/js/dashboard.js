//onload
    // loads home
    // nav button functions
    // 
document.addEventListener("DOMContentLoaded", () => {
    loadContent('home'); //home by default, change it when youre testing smth

    // default 1st active button is home
    let activeButton = document.getElementById('nav-button-home');
    const activeImage = activeButton.querySelector('img');
    activeImage.src = activeImage.src.replace('.png', '-alt.png');
    
    //loads the button's section and updates button image
    document.querySelectorAll('[id^="nav-button-"]:not(#nav-button-logout)').forEach((button) => {
        button.addEventListener("click", () => {
            if(button === activeButton) return;

            const section = button.id.replace("nav-button-", "");
            loadContent(section);

            if (activeButton && activeButton != button){
                const previousImg = activeButton.querySelector('img');
                previousImg.src = previousImg.src.replace("-alt.png", ".png"); 
            }
    
            //changes new active button source to alt
            const currentImg = button.querySelector('img');
            currentImg.src = currentImg.src.replace(".png", "-alt.png");
    
            activeButton = button;
        });
    });

    //logout button function
    const logoutButton = document.getElementById('nav-button-logout');
    const logoutConfirmScreen = document.getElementById('logout-confirmation');
    const logoutCancel = document.getElementById('cancel-logout');
    const logoutConfirm = document.getElementById('confirm-logout');
    logoutButton.addEventListener('click', () => {
        logoutConfirmScreen.classList.remove('hidden');
    });

    logoutCancel.addEventListener('click', () => {
        logoutConfirmScreen.classList.add('hidden');
    });
    logoutConfirm.addEventListener('click', () => {
        fetch("src/controllers/logout.php", { method: "POST" })
            .then(() => {
                window.location.href = "login.php";
            });
    });    
});


//Load Main Page Content
function loadContent(content) {
    const contentContainer = document.getElementById('content-container');
    //loading indicator
    contentContainer.classList.add('items-center', 'justify-center');
    contentContainer.innerHTML = `<p class='text-lg text-center'>Loading...</p>`;
    //ajax request
    $.ajax({
        url: `sections/${content}.php`,
        method: "GET",
        success: function(response) {
            // console.log("Response:", response);
            contentContainer.innerHTML = response;
            switch(content){
                case 'home':
                case 'employees':
                    attachEmployeeButtonListeners();
                    break;
            }
        },
        error: function(xhr, status, error) {
            // console.error("Error loading content:", error);
            contentContainer.innerHTML = "<p>Error loading content.</p>";
        }
    });
}


//Employee vsection button functions
let activeViewButton = null;
let activeViewId = null;

function attachEmployeeButtonListeners(){
    document.querySelectorAll('[id^="view-button-"]').forEach((button) => {
        button.dataset.state = "off";
        button.addEventListener("click", () => {
            const image = button.querySelector('img');
            if(button.dataset.state === "off"){
                if(activeViewButton){
                    const activeImage = activeViewButton.querySelector('img');
                    activeImage.src = activeImage.src.replace("-alt.png", ".png");
                    activeViewButton.dataset.state = "off";
                }
                image.src = image.src.replace(".png", "-alt.png");
                button.dataset.state = "on";
                activeViewButton = button;
            } else {
                image.src = image.src.replace("-alt.png", ".png");
                button.dataset.state = "off";
                activeViewButton = null;
            }
            const parts = button.id.split('-');
            const employeeId = parts[2];
            const position = parts[3];
            loadEmployeeInformation(employeeId, position);
        })
    })

    document.querySelectorAll('[id^="delete-button-"]').forEach((button) => {
        button.dataset.state = "off";
        button.addEventListener("click", () => {
            const image = button.querySelector('img');
            if(button.dataset.state === "off"){
                image.src = image.src.replace(".png", "-alt.png");
                button.dataset.state = "on";
            } else {
                image.src = image.src.replace("-alt.png", ".png");
                button.dataset.state = "off";
            }
        })
    })
}

//Loads Employee Information Card
function loadEmployeeInformation(employeeId, position){
    const employeeInfoCard = document.getElementById('employee-information');

    if(employeeInfoCard.classList.contains("hidden")){ //if no active, show card
        employeeInfoCard.classList.remove("hidden");
        activeViewId = employeeId;
        fetch(`../src/controllers/load-employee-info.php?employeeId=${employeeId}&position=${position}`)
            .then(response => response.json())
            .then(data => {
                //update employee info
                console.log(data);
                document.getElementById('name-details-input').value = data.name;
                document.getElementById('employeeId-details-input').value = data.employee_id;
                document.getElementById('position-details-input').value = position;
                document.getElementById('gender-details-input').value = data.gender;
                document.getElementById('isActive-details-input').value = data.is_active;
                document.getElementById('address-details-input').value = data.address;
                document.getElementById('email-details-input').value = data.email;
                document.getElementById('birthDate-details-input').value = data.birth_date;
                document.getElementById('contactNumber-details-input').value = data.contact_number;
                document.getElementById('hireDate-details-input').value = data.hire_date;
                document.getElementById('password-details-input').value = data.password_text;
                document.getElementById('salary-details-input').value = data.salary;
                document.getElementById('extra-details-label').textContent = (position==="Manager") ? "Bonus Percentage:" : "Manager ID:";
                document.getElementById('extra-details-input').value = (position==="Manager") ? data.bonus_percentage : data.manager_id;
            })
            .catch(error => console.error("Error: ", error));
    } else if (activeViewId != employeeId){ //else if activeId != pressedId then update the card
        activeViewId = employeeId;
        fetch(`../src/controllers/load-employee-info.php?employeeId=${employeeId}&position=${position}`)
            .then(response => response.json())
            .then(data => {
                //update employee info
            })
            .catch(error => console.error("Error: ", error));
    }
    else { //else hide the card
        employeeInfoCard.classList.add("hidden");
        activeViewId = null;
    }
}