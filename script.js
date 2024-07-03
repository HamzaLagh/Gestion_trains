document.addEventListener('DOMContentLoaded', function () {
    fetch('php/get_trains.php')
        .then(response => response.json())
        .then(trains => {
            const timelineBody = document.querySelector('.timeline-body');
            const trackElements = {};

            trains.forEach(train => {
                const voieName = train.voie_name;
                if (!trackElements[voieName]) {
                    trackElements[voieName] = document.createElement('div');
                    trackElements[voieName].classList.add('track');
                    trackElements[voieName].innerHTML = `<div class="track-label">${voieName}</div>`;
                    timelineBody.appendChild(trackElements[voieName]);
                }

                const trainElement = document.createElement('div');
                trainElement.classList.add('train', train.nature === 'Maintenance' ? 'maintenance' : 'in-service');
                
                const departureTime = new Date(`1970-01-01T${train.departure_time}Z`);
                const arrivalTime = new Date(`1970-01-01T${train.arrival_time}Z`);
                const duration = (arrivalTime - departureTime) / (1000 * 60); // in minutes

                const leftPercentage = (departureTime.getHours() * 60 + departureTime.getMinutes()) / 1440 * 100;
                const widthPercentage = duration / 1440 * 100;

                trainElement.style.left = `${leftPercentage}%`;
                trainElement.style.width = `${widthPercentage}%`;

                trainElement.innerHTML = `<span class="train-label">${train.number}</span>`;
                trackElements[voieName].appendChild(trainElement);
            });

            // Update current time bar position
            function updateCurrentTimeBar() {
                const now = new Date();
                const totalMinutes = now.getHours() * 60 + now.getMinutes();
                const leftPercentage = totalMinutes / 1440 * 100;
                const currentTimeBar = document.querySelector('.current-time-bar');
                if (currentTimeBar) {
                    currentTimeBar.style.left = `${leftPercentage}%`;
                } else {
                    const newTimeBar = document.createElement('div');
                    newTimeBar.classList.add('current-time-bar');
                    newTimeBar.style.left = `${leftPercentage}%`;
                    document.querySelector('.timeline-container').appendChild(newTimeBar);
                }
            }

            setInterval(updateCurrentTimeBar, 60000); // Update every minute
            updateCurrentTimeBar();
        })
        .catch(error => console.error('Error fetching data:', error));
});


