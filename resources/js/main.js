function popup(html, title = "") {
    document.getElementById("popup").classList.remove("hidden");
    document.getElementById("popup-content").innerHTML = html;
    document.getElementById("popup-title").innerHTML = title;
}

function openPopup(route, title = "") {
    fetch(route)
        .then((response) => response.text())
        .then((data) => {
            let obj = document.createElement("div");
            obj.innerHTML = data;
            popup(obj.innerHTML, title);
        });
}

function closePopup() {
    document.getElementById("popup").classList.add("hidden");
    document.getElementById("popup-content").innerHTML = "";
    document.getElementById("popup-title").innerHTML = "";
}

async function changeLike(post, action) {
    likebutton = document.getElementById("likebutton-" + post);
    if (action == "like") {
        likebutton.innerHTML = `<img onclick="changeLike(${post}, 'unlike')" src="/resources/icons/heart-filled.svg" alt="likebutton" class="w-6 h-6">`;
    } else if (action == "unlike") {
        likebutton.innerHTML = `<img onclick="changeLike(${post}, 'like')" src="/resources/icons/heart.svg" alt="likebutton" class="w-6 h-6">`;
    }
    await fetch("/likes/change/" + post + "/" + action);
    likecount = fetch("/likes/count/" + post)
        .then((response) => response.text())
        .then((data) => {
            document.getElementById("likecount-" + post).innerHTML = data;
        });
}

// init highlight.js
function inithighlight() {
    document.addEventListener('DOMContentLoaded', () => {
        const codeBlocks = document.querySelectorAll('pre code');
        codeBlocks.forEach((codeBlock) => {
            hljs.highlightElement(codeBlock);
        });
    });
}