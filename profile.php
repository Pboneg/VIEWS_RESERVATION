<?php include 'header.php'; ?>
<div class="container-fluid">
    <h3 class="text-dark mb-4">Administration</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    <img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/1547510251.png" width="160" height="160">
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Charger une photo</button></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Ajouter un événement</p>
                        </div>
                        <div class="card-body">
                            <form id="addEventForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label" for="title"><strong>Nom de l'événement</strong></label>
                                    <input class="form-control" type="text" id="title" placeholder="Nom de l'événement" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="description"><strong>Description</strong></label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="location"><strong>Lieu</strong></label>
                                    <input class="form-control" type="text" id="location" placeholder="Lieu de l'événement" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="event_date"><strong>Date</strong></label>
                                    <input class="form-control" type="date" id="event_date" name="event_date" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="available_seats"><strong>Sièges disponibles</strong></label>
                                    <input class="form-control" type="number" id="available_seats" name="available_seats" min="1" required>
                                </div>
                                <input type="hidden" id="max_attendees" name="max_attendees" required>
                                <div class="mb-3">
                                    <label class="form-label" for="reservations_closed"><strong>Réservations closes</strong></label>
                                    <input class="form-check-input" type="checkbox" id="reservations_closed" name="reservations_closed">
                                    <label class="form-check-label" for="reservations_closed">Cocher si les réservations sont fermées</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="image"><strong>Image</strong></label>
                                    <input class="form-control" type="file" id="image" name="image" accept=".jpeg,.png,.jpg">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Ajouter un Événement</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="text-dark mb-4">Gestion des événements</h3>
    <div class="card shadow mt-5">
        <div class="card-header py-3">
            <p class="text-primary m-0">Liste des événements à gérer</p>
        </div>
        <div class="card-body overflow-auto">
            <table id="dataTable2" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom de l'événement</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Action</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody id="eventTableBody">
                    <!-- Les événements seront insérés ici par JavaScript -->
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nom de l'événement</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Action</th>
                        <th>Détails</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="assets/js/script.js"></script>



<script>
    const API_BASE_URL = "http://localhost:8000/api/events";

    const addEventForm = document.getElementById('addEventForm');
    const availableSeatsInput = document.getElementById('available_seats');
    const maxAttendeesInput = document.getElementById('max_attendees');

    // Synchroniser les sièges disponibles avec les participants max
    availableSeatsInput.addEventListener('input', function() {
        maxAttendeesInput.value = availableSeatsInput.value;
    });

    // Gérer la soumission du formulaire d'ajout d'événement
    addEventForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(addEventForm); 

        try {
            const response = await fetch(API_BASE_URL, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                body: formData 
            });

            const result = await response.json();

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(`Erreur ${response.status}: ${errorData.message || "Erreur lors de l'ajout de l'événement."}`);
            }

            alert("Événement créé avec succès !");
            addEventForm.reset(); // Réinitialiser le formulaire
            fetchEvents(); // Recharger la liste des événements
        } catch (error) {
            console.error('Erreur lors de l\'ajout de l\'événement :', error);
            alert('Une erreur est survenue : ' + error.message);
        }
    });

    // Fonction pour récupérer et afficher les événements
    async function fetchEvents() {
        try {
            const response = await fetch(API_BASE_URL, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`, 
                }
            });

            if (!response.ok) {
                throw new Error("Erreur lors de la récupération des événements.");
            }

            const events = await response.json();
            displayEvents(events.data);
        } catch (error) {
            console.error(error);
            alert("Une erreur est survenue lors du chargement des événements.");
        }
    }

    // Fonction pour afficher les événements dans le tableau
    function displayEvents(events) {
        const tableBody = document.getElementById('eventTableBody');
        tableBody.innerHTML = '';  // Réinitialiser le tableau

        events.forEach(event => {
            const eventDate = new Date(event.event_date);
            const currentDate = new Date();
            const isPastEvent = eventDate < currentDate;
            const status = event.reservations_closed || isPastEvent ? 'Fermé' : 'Ouvert';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${event.title}</td>
                <td>${eventDate.toLocaleDateString()}</td>
                <td>${status}</td>
                <td>
                    <button class="btn btn-primary" onclick="editEvent(${event.id})">Modifier</button>
                    <button class="btn btn-danger" onclick="deleteEvent(${event.id})">Supprimer</button>
                </td>
                <td><button class="btn btn-primary" onclick="viewEvent(${event.id})">Voir plus</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Appel initial pour charger les événements
    fetchEvents();

    // Fonction pour supprimer un événement
    async function deleteEvent(eventId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
            try {
                await fetch(`${API_BASE_URL}/${eventId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                fetchEvents();  // Recharger la liste des événements après suppression
            } catch (error) {
                console.error('Erreur lors de la suppression de l\'événement :', error);
                alert("Erreur lors de la suppression de l'événement.");
            }
        }
    }

    // Fonction pour rediriger vers la page d'édition
    function editEvent(eventId) {
        // Redirection vers une page d'édition de l'événement
        window.location.href = `http://localhost/reservation/event_details.php?event_id=${eventId}`;
    }

    // Fonction pour afficher l'évènement
    function viewEvent(eventId){
        // Redirection vers une page d'édition de l'événement
        window.location.href = `http://localhost/reservation/event_plus.php?event_id=${eventId}`;
    }

</script>
</body>
</html>
