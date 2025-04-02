document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[id^="nav-button-"]').forEach((button) => {
        button.addEventListener("click", () => {
            const section = button.id.replace("nav-button-", "");
            loadContent(section);
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

