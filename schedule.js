document.getElementById('eventForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var event = document.getElementById('event').value;

    // You can perform additional validation here if needed

    // Display confirmation message
    document.getElementById('eventForm').style.display = 'none';
    document.getElementById('confirmation').style.display = 'block';
});
