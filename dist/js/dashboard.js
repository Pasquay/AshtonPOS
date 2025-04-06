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


//Employee vsection button functions
let activeViewButton = null;

function attachEmployeeButtonListeners(){
    document.querySelectorAll('[id^="view-button-"]').forEach((button) => {
        button.dataset.state = "off";
        button.addEventListener("click", () => {
            const image = button.querySelector('img');
            if(button.dataset.state === "off"){
                if(activeViewButton){
                    const activeImage = activeViewButton.querySelector('img');
                    activeImage.src = activeImage.src.replace("-alt.png", ".png");
                }
                image.src = image.src.replace(".png", "-alt.png");
                button.dataset.state = "on";
                activeViewButton = button;
            } else {
                image.src = image.src.replace("-alt.png", ".png");
                button.dataset.state = "off";
            }
        })
        // const employeeId = button.id.split('-').pop()
        // loadEmployeeInformation(employeeId);
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
            console.log("Response:", response); // Debug the response
            contentContainer.innerHTML = response;
            switch(content){
                case 'home':
                case 'employees':
                    attachEmployeeButtonListeners();
                    break;
            }
        },
        error: function(xhr, status, error) {
            console.error("Error loading content:", error); // Debug the error
            contentContainer.innerHTML = "<p>Error loading content.</p>";
        }
    });
}

//Loads Employee Information Card
function loadEmployeeInformation(){
    const employeeInfoCard = document.getElementById('employee-information');
    //if no active, show card
    if(employeeInfoCard.classList.contains("hidden")){
        employeeInfoCard.classList.remove("hidden");
    }
    //else if activeId != pressedId then update the card
    //if activeId == pressedId then hide the card
    //else hide the card
}