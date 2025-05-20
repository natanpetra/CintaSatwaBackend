function updateClock() {
    // Get current date and time
    const now = new Date();

    // Extract hours, minutes, and seconds
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    // Add leading zero to single-digit hours, minutes, and seconds
    hours = (hours < 10) ? '0' + hours : hours;
    minutes = (minutes < 10) ? '0' + minutes : minutes;
    seconds = (seconds < 10) ? '0' + seconds : seconds;

    //Add into element
    let hourElem = document.querySelector('#hour');
    let minuteElem = document.querySelector('#minute');

    hourElem.innerText = hours;
    minuteElem.innerText = minutes
}

function displayDate() {
    const now = new Date();

    // Array of days in Indonesian
    const daysOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    // Array of months in Indonesian
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Get the day of the week (0-6)
    const day = daysOfWeek[now.getDay()];

    // Get the day of the month (1-31)
    const date = now.getDate();

    // Get the month (0-11)
    const month = months[now.getMonth()];

    // Get the full year (e.g., 2024)
    const year = now.getFullYear();

    // Format the full date string in Indonesian (e.g., "Minggu, 17 Maret 2024")
    const fullDate = `${day}, ${date} ${month} ${year}`;

    // Update the text content of the #dateDisplay element
    document.getElementById('date').textContent = fullDate;
}

// Call the function to display the date immediately and then update it every second
setInterval(displayDate, 1000);
displayDate();  // Initial call to display the current date


// Update the clock every 1000 milliseconds (1 second)
setInterval(updateClock, 1000);

// Initial call to display the time immediately on page load
updateClock();