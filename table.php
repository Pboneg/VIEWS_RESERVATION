
        <?php include './header.php'; ?>
        
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Base de données des étudiants et diplômés de l'USTM</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Liste des diplômés de l'USTM</p>
                        </div>
                        <div class="card-body overflow-auto">
                            <table id="dataTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Lieu</th>
                                        <th>Date</th>
                                        <th>Places disponibles</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="events">
                                    <!-- Les événements sont ajoutés ici par JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Lieu</th>
                                        <th>Date</th>
                                        <th>Places disponibles</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php include './footer.php'; ?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>

    <script>
        // URL de l'API Laravel
        const API_BASE_URL = "http://localhost:8001/api";
        const token = localStorage.getItem('token');

        // Fonction pour récupérer et afficher la liste des événements
        async function fetchEvents() {
            try {
                // Requête GET pour récupérer les événements
                const response = await fetch(`${API_BASE_URL}/events`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la récupération des événements.');
                }

                const events = await response.json();
                displayEvents(events.data);  // Affichez les événements sur la page
            } catch (error) {
                console.error(error);
            }
        }

        // Fonction pour afficher les événements dans le DOM
        function displayEvents(events) {
            const eventsContainer = document.getElementById('events');

            // Efface les lignes existantes dans le tableau
            eventsContainer.innerHTML = '';


            // Parcourir les événements et les ajouter à la page
            // Parcourir les événements et les ajouter à la table
            events.forEach(event => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${event.title}</td>
                    <td>${event.description}</td>
                    <td>${event.location}</td>
                    <td>${new Date(event.event_date).toLocaleDateString()}</td>
                    <td>${event.available_seats}/${event.max_attendees}</td>
                    <td><button onclick="reserveEvent(${event.id})">Réserver</button></td>
                `;

                eventsContainer.appendChild(row);
            });
        }

        // Fonction pour réserver un événement
        async function reserveEvent(eventId) {
            const numberOfSeats = prompt("Combien de places souhaitez-vous réserver ?");

            if (!numberOfSeats || isNaN(numberOfSeats) || numberOfSeats <= 0) {
                alert("Veuillez entrer un nombre valide de places.");
                return;
            }

            try {
                const response = await fetch(`${API_BASE_URL}/bookings`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        event_id: eventId,
                        number_of_seats: parseInt(numberOfSeats)  // Convertir en entier
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Erreur lors de la réservation.');
                }

                const result = await response.json();
                alert("Réservation réussie ! Détails : " + JSON.stringify(result));

                // Recharge la liste des événements pour voir les places disponibles mises à jour
                fetchEvents();
            } catch (error) {
                console.error(error);
                alert(error.message);
            }
        }

        // Appel initial pour charger les événements
        fetchEvents();

    </script>
</body>

</html>