// $(document).ready(function() {
//   // Select notification elements
//   var notificationLink = $('#notification-link');
//   var notificationModal = $('#notification-modal');
//   var notificationCount = $('#notification-count');

//   // Initialize notification count
//   var unreadCount = parseInt(notificationLink.data('unread-count'));
//   if (unreadCount > 0) {
//     notificationCount.text(unreadCount);
//     notificationLink.addClass('text-warning');
//   }

//   // Update notification count and badge function
//   function updateNotificationCount(count) {
//     if (count > 0) {
//       notificationCount.text(count);
//       notificationLink.addClass('text-warning');
//     } else {
//       notificationCount.text('');
//       notificationLink.removeClass('text-warning');
//     }
//   }

//   // Send AJAX request to get notifications
//   function getNotifications() {
//     $.ajax({
//       url: notificationsUrl,
//       method: 'GET',
//       success: function(response) {
//         var notifications = response.notifications;
//         var notificationList = $('#notification-list');

//         // Empty the list before adding new items
//         notificationList.empty();

//         // Loop through notifications and add to list
//         for (var i = 0; i < notifications.length; i++) {
//           var notification = notifications[i];

//           // Convert created_at string to Date object
//           var date = new Date(notification.created_at);

//           // Format time in 12-hour format (HH:MM AM/PM)
//           var time = '<span class="text-blue" style="color: skyblue;">' + date.toLocaleTimeString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true}) + '</span>';

//           // Build list item text
//           var listItemText = time + ':  <span class="text-green" style="color: lightgreen;">' + notification.message + '</span> Customer ID:  ' + notification.appointment_customer_id + ' <span class="text-green">Appointment Date: ' + notification.appointment_datetime + '-' + notification.appointment_end_time + ':00</span>';

//           // Create list item element and set text
//           var listItem = $('<li>').html(listItemText);

//           // Set data attribute for notification ID
//           listItem.attr('data-notification-id', notification.id);

//           // Add list item to list
//           notificationList.append(listItem);

//           // Increment unread count if notification is unread
//           if (notification.read_at === null) {
//             unreadCount++;
//           }
//         }

//         // Update notification count and badge
//         updateNotificationCount(unreadCount);
//       },
//       error: function() {
//         console.log('Error fetching notifications');
//       }
//     });
//   }

//   // Show notification modal on link click
//   notificationLink.click(function(e) {
//     e.preventDefault();
//     notificationModal.modal('show');
//   });

//   // When modal is shown, get notifications and mark as read
//   notificationModal.on('show.bs.modal', function() {
//     // Send AJAX request to get notifications
//     getNotifications();
//     // Update unread count and badge
//     unreadCount = 0;
//     updateNotificationCount(unreadCount);
//   });

//   // When modal is hidden, remove all notifications from list and reset unread count
//   notificationModal.on('hidden.bs.modal', function() {
//     var notificationList = $('#notification-list');
//     notificationList.empty();
//     unreadCount = 0;
//     updateNotificationCount(unreadCount);
//   });

//   // Poll for new notifications every 5 seconds
//   setInterval(function() {
//     getNotifications();
//   }, 5000);
// });




function openNotificationsModal() {
        document.getElementById("notificationsModal").style.display = "block";
    }

    function closeNotificationsModal() {
        document.getElementById("notificationsModal").style.display = "none";
    } 

$(document).ready(function() {
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle "Mark all as read" link click
        $('#mark-all-as-read').click(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '/notifications/mark-all-as-read',
                success: function(response) {
                    if (response.success) {
                        // Reload the notification list
                        window.location.reload();
                    }
                }
            });
        });
    });


