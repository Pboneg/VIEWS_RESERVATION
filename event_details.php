<?php include 'header.php'; ?>

<div class="container-fluid">
    <h2 class="text-center my-4">Détails de l'événement</h2>

    <!-- Section pour afficher l'événement -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg mb-5">
                <img id="eventImage" class="card-img-top" alt="Image de l'événement" src="default.jpg" style="height: 400px; object-fit: cover;">
                <div class="card-body">
                    <h3 class="card-title" id="eventTitle"></h3>
                    <p class="card-text" id="eventDescription"></p>
                    <p><strong>Lieu :</strong> <span id="eventLocation"></span></p>
                    <p><strong>Date :</strong> <span id="eventDate"></span></p>
                    <p><strong>Places disponibles :</strong> <span id="eventSeats"></span></p>
                </div>
            </div>

            <!-- Section de réservation -->
            <div class="card shadow-lg mb-3">
                <div class="card-body">
                    <h4>Informations sur la réservation</h4>
                    <p><strong>Nombre de places réservées :</strong> <span id="reservationSeats"></span></p>
                    <p><strong>Status :</strong> <span id="reservationStatus"></span></p>
                    <button class="btn btn-primary" id="reserveBtn">Modifier ma réservation</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour récupérer les détails de l'événement
async function fetchEventDetails(eventId) {
    try {
        const response = await fetch(`http://localhost:8000/api/events/${eventId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        
        const event = await response.json();

        document.getElementById('eventTitle').innerText = event.title;
        document.getElementById('eventDescription').innerText = event.description;
        document.getElementById('eventLocation').innerText = event.location;
        document.getElementById('eventDate').innerText = new Date(event.event_date).toLocaleDateString();
        document.getElementById('eventSeats').innerText = event.available_seats;

        if (event.image) {
            document.getElementById('eventImage').src = event.image;
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données de l\'événement :', error);
    }
}

// Fonction pour récupérer les détails de la réservation de l'utilisateur
async function fetchReservationDetails(eventId) {
    try {
        const response = await fetch(`http://localhost:8000/api/events?event_id=${eventId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        
        const reservation = await response.json();

        // Remplir les données de la réservation sur la page
        document.getElementById('reservationSeats').innerText = reservation.number_of_seats || 'Aucune réservation';
        document.getElementById('reservationStatus').innerText = reservation.status || 'Non réservé';

    } catch (error) {
        console.error('Erreur lors de la récupération des détails de la réservation :', error);
    }
}

// Récupérer l'ID de l'événement depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const eventId = urlParams.get('event_id');

// Charger les détails de l'événement et de la réservation
fetchEventDetails(eventId);
fetchReservationDetails(eventId);
</script>

<?php include 'footer.php'; ?>
