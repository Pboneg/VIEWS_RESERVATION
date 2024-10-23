<?php include 'header.php'; ?>

<div class="container-fluid">
    <h2 class="text-center my-4">Détails de l'événement</h2>

    <!-- Section pour afficher l'événement -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg mb-5">
                <!-- L'image sera injectée dynamiquement ici -->
                <img id="eventImage" class="card-img-top" alt="Image de l'événement" src="default.jpg" style="height: 400px; object-fit: cover;">
                <div class="card-body">
                    <!-- Le titre -->
                    <h3 class="card-title" id="eventTitle"></h3>

                    <!-- La description -->
                    <p class="card-text" id="eventDescription"></p>

                    <!-- Le lieu -->
                    <p><strong>Lieu :</strong> <span id="eventLocation"></span></p>

                    <!-- La date -->
                    <p><strong>Date :</strong> <span id="eventDate"></span></p>

                    <!-- Le nombre de places disponibles -->
                    <p><strong>Places disponibles :</strong> <span id="eventSeats"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour récupérer les détails de l'événement via une API
async function fetchEventDetails(eventId) {
    try {
        // Récupérer les détails de l'événement depuis votre API Laravel
        const response = await fetch(`http://localhost:8001/api/events/${eventId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`, 
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`);
        }

        // Récupérer les données JSON
        const eventData = await response.json();
        const event = eventData.data;  // Accéder à l'objet "data"
        console.log(event); 

        // Injecter dynamiquement les données dans le HTML
        document.getElementById('eventTitle').innerText = event.title;
        document.getElementById('eventDescription').innerText = event.description;
        document.getElementById('eventLocation').innerText = event.location;
        document.getElementById('eventDate').innerText = new Date(event.event_date).toLocaleDateString();
        document.getElementById('eventSeats').innerText = event.available_seats;

        // Modifier la source de l'image s'il y a une image
        if (event.image) {
            document.getElementById('eventImage').src = event.image;
        }

    } catch (error) {
        console.error('Erreur lors de la récupération des données de l\'événement :', error);
    }
}

// Récupérer l'ID de l'événement depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const eventId = urlParams.get('event_id');

// Charger les détails de l'événement
fetchEventDetails(eventId);
</script>

<?php include 'footer.php'; ?>
