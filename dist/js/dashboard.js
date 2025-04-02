//nav button functional
document.addEventListener("DOMContentLoaded", () => {
    // loadContent('home'); //home by default, change it when youre testing smth

    //default 1st active button is home
    // let activeButton = document.getElementById('nav-button-pos');
    // const activeImage = activeButton.querySelector('img');
    // activeImage.src = activeImage.src.replace('.png', '-alt.png');
    
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


function loadContent(content) {
    const contentContainer = document.getElementById('content-container');
    //loading indicator
    contentContainer.classList.add('items-center', 'justify-center');
    contentContainer.innerHTML = `<p class='text-lg text-center'>Loading...</p>`;
    //ajax request
    $.ajax({
        url: `sections/${content}.php`,
        method: "GET",
        success: function(response){
            contentContainer.innerHTML = response;
        },
        error: function(){
            contentContainer.innerHTML = "<p>Error loading content.</p>";
        }
    });
}