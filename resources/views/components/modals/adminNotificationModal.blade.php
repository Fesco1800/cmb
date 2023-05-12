{{-- @props(['notifications']) --}}


<div class="modal fade" id="adminNotificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notifications</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                 {{-- @if(isset($notifications))
                    <ul class="list-group">
                      @foreach(json_decode($notifications) as $notification)
                        <li class="list-group-item">
                          {{ $notification->message }}
                        </li>
                      @endforeach
                    </ul>
                  @endif --}}
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
// $(document).ready(function() {
//     // Check for new notifications when the modal is shown
//     $('#adminNotificationModal').on('show.bs.modal', function (event) {
//         // Get the modal body and check if it has any new data
//         var modalBody = $(this).find('.modal-body');
//         if (modalBody.html().trim() === '') {
//             // No new notifications, update the icon to a bell
//             $('#notification-icon').removeClass('fa-bell-slash').addClass('fa-bell');
//         } else {
//             // New notifications, update the icon to a bell with a slash
//             $('#notification-icon').removeClass('fa-bell').addClass('fa-bell-slash');
//         }
//     });
// });
</script>



