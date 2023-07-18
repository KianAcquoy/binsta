let biography = document.getElementById('biography');
let original = String(biography.value);
let editbutton = document.getElementById('editbutton');
biography.style.height = "";biography.style.height = biography.scrollHeight + 2 + "px";
biography.addEventListener('input', function () {
    this.style.height = "";this.style.height = this.scrollHeight + 2 + "px";
    if (original != biography.value) {
        editbutton.classList.contains('hidden') ? editbutton.classList.remove('hidden') : null;
    } else if (!editbutton.classList.contains('hidden')) {
        editbutton.classList.add('hidden');
    }
});
editbutton.addEventListener('click', function () {
    document.getElementById('bioform').submit();
});