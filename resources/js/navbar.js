let searchbar = document.getElementById("searchbar");
searchbar.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        window.location.href = "/search/users/" + searchbar.value;
    }
});