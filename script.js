// JavaScript untuk mengubah form antara Employee dan Hirer
const employeeBtn = document.getElementById('employee-btn');
const hirerBtn = document.getElementById('hirer-btn');
const formTitle = document.getElementById('form-title');

// Fungsi untuk mengubah tampilan form
function switchForm(role) {
    formTitle.textContent = `Apply as a ${role}`;
}

// Event Listener untuk tombol Employee
employeeBtn.addEventListener('click', () => {
    switchForm('Employee');
    employeeBtn.classList.add('active');
    hirerBtn.classList.remove('active');
});

// Event Listener untuk tombol Hirer
hirerBtn.addEventListener('click', () => {
    switchForm('Hirer');
    hirerBtn.classList.add('active');
    employeeBtn.classList.remove('active');
});
