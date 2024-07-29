function createUser() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const mobile = document.getElementById('mobile').value;

    fetch('user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, email, mobile })
    })
        .then(response => response.json())
        .then(data => alert(data.message))
        .catch(error => console.error('Error:', error));
}

function addExpense() {
    const amount = document.getElementById('amount').value;
    const method = document.getElementById('method').value;
    const description = document.getElementById('description').value;
    const name = document.getElementById('username').value;

    fetch('expense.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ amount, method, description, name })
    })
        .then(response => response.json())
        .then(data => alert(data.message))
        .catch(error => {
            console.log(`Error: ${error}`);
        });
}

function fetchExpenses() {
    fetch('expense.php')
        .then(response => response.json())
        .then(data => {
            const expensesList = document.getElementById('expenses');
            expensesList.innerHTML = '';
            data.forEach(expense => {
                const listItem = document.createElement('li');
                listItem.textContent = `${expense.description}: $${expense.amount}`;
                expensesList.appendChild(listItem);
            });
        })
        .catch(error => {
            console.log(`Error: ${error}`);
        });
}

document.addEventListener('DOMContentLoaded', fetchExpenses);
