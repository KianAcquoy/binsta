let biography = document.getElementById('biography');
biography.style.height = "";biography.style.height = biography.scrollHeight + 2 + "px";
biography.addEventListener('input', function () {
    this.style.height = "";this.style.height = this.scrollHeight + 2 + "px";
});

function uploadAvatar() {
    let avatar = document.getElementById('avatar');
    avatar.dispatchEvent(new MouseEvent('click'));
}