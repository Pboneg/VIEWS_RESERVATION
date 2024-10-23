<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - Reservations</title>
    <meta name="description" content="Application web permettant de mettre de gérer les utilisateurs, les authentifications, faire des reservations et recevoir des notifications de noueaux évènements">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0 w-100 bg-gradient" href="#" style="background: #fff;">
                    <div class="sidebar-brand-icon"><img src="assets/img/Fichier%201.png" style="width: 80px;"></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-tachometer-alt"></i><span>Tableau de bord</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="table.php"><i class="fas fa-table"></i><span>Liste des évènements</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="logout()"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none">
                        <path d="M8.51428 20H4.51428C3.40971 20 2.51428 19.1046 2.51428 18V6C2.51428 4.89543 3.40971 4 4.51428 4H8.51428V6H4.51428V18H8.51428V20Z" fill="currentColor"></path>
                        <path d="M13.8418 17.385L15.262 15.9768L11.3428 12.0242L20.4857 12.0242C21.038 12.0242 21.4857 11.5765 21.4857 11.0242C21.4857 10.4719 21.038 10.0242 20.4857 10.0242L11.3236 10.0242L15.304 6.0774L13.8958 4.6572L7.5049 10.9941L13.8418 17.385Z" fill="currentColor"></path>
                    </svg><span>Déconnexion</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline">
                    <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input class="bg-light form-control border-0 small" type="text" placeholder="Chercher ici..">
                                <button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                        <span class="badge bg-danger badge-counter">0</span>
                                        <i class="fas fa-bell fa-fw"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">Notifications</h6>
                                        <div class="dropdown-list"></div>
                                        <a class="dropdown-item text-center small text-gray-500" href="#">Voir toutes les alertes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                    <span class="badge bg-danger badge-counter">0</span>
                                    <i class="fas fa-envelope fa-fw"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                    <h6 class="dropdown-header">Messages de diffusion</h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="me-3">
                                            <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                        </div>
                                        <div>
                                            <span class="small text-gray-500">07 janvier 2023</span>
                                            <p>Votre inscription a bien été enregistrée !</p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Voir tous les messages</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Bienvenue</h1>
                </div>

                <!-- Scripts pour Laravel Echo et Pusher -->
                <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

                <script>
                    const token = localStorage.getItem('token');

                    // Initialisation de Laravel Echo avec Pusher
                    const echo = new Echo({
                        broadcaster: 'pusher',
                        key: 'b038bf50e19df075d9d9', 
                        cluster: 'mt1', 
                        forceTLS: true,
                    });

                    // Variable pour stocker le nombre de notifications non lues
                    let notificationCount = 0;

                    // Fonction pour mettre à jour le compteur de notifications
                    function updateNotificationCount() {
                        const badge = document.querySelector('.badge-counter');
                        badge.textContent = notificationCount > 0 ? notificationCount : '0';
                    }

                    // Fonction pour ajouter une notification à la liste
                    function addNotification(notification) {
                        const notificationList = document.querySelector('.dropdown-list');
                        const notificationElement = document.createElement('a');
                        notificationElement.className = 'dropdown-item d-flex align-items-center';
                        notificationElement.href = `/notifications/${notification.id}`;

                        const eventTitle = notification.event_title || 'Nouvel événement';
                        const message = notification.message || 'Vous avez une nouvelle notification.';

                        notificationElement.innerHTML = `
                            <div class="me-3">
                                <div class="bg-primary icon-circle"><i class="fas fa-bell text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">${new Date().toLocaleString()}</span>
                                <p><strong>${eventTitle}</strong>: ${message}</p>
                            </div>
                        `;

                        // Ajouter la notification en haut de la liste
                        notificationList.insertBefore(notificationElement, notificationList.querySelector('.dropdown-item.text-center'));
                    }

                    // Écouter les notifications en temps réel via Laravel Echo
                    echo.channel('notifications') 
                        .listen('NotificationCreated', (e) => {
                            // Incrémenter le compteur de notifications
                            notificationCount++;
                            updateNotificationCount();

                            // Ajouter la notification à la liste
                            addNotification(e.notification);
                        });

                    document.addEventListener("DOMContentLoaded", function() {
                        // Charger les notifications initiales depuis l'API
                        fetch('http://localhost:8000/api/notifications', {
                            headers: {
                                'Authorization': `Bearer ${token}`
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur lors du chargement des notifications');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);

                            notificationCount = data.unread_count || 0;
                            updateNotificationCount();

                            // Vérifiez si unread est un tableau
                            if (Array.isArray(data.notifications.unread)) {
                                data.notifications.unread.forEach(notification => {
                                    addNotification(notification);
                                });
                            } else {
                                console.error('Les notifications non lues ne sont pas un tableau:', data.notifications.unread);
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                    });

                    function logout() {
                 
                    // Faire la requête à l'API pour révoquer le token
                    fetch('http://localhost:8000/api/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la déconnexion');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message); // Déconnexion réussie

                        // Supprimer le token du stockage local
                        localStorage.removeItem('token');

                        // Rediriger l'utilisateur vers la page de login
                        window.location.href = 'http://localhost:8080/reservation/login.html'; 
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la déconnexion.');
                    });
                }

                </script>

