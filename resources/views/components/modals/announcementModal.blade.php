<div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModal" aria-hidden="true">
  <div class="modal-dialog" role="document" style="height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="modal-content">
      <div class="modal-body" style="padding: 0;">
        <div style="position: absolute; top: 0; width: 100%; height: 100%; background: rgba(0,0,0, 0.2)"></div>
        @if(!empty($details->announcement_img) ? $details->announcement_img : 'No photos')
          <img src="/images/maintenance/{{ !empty($details->announcement_img) ? $details->announcement_img : 'No photos' }}" alt="Announcement Image" style="width:100%;">
        @else
         <img src="https://via.placeholder.com/350x150.png" alt="Announcement Image" style="width:100%;">
        @endif
        <div style="position: absolute;width: 100%;height: 100%;top: 0; font-family: Poppins, sans-serif; font-size: 12px;  " >
            <div style="display: flex; flex-direction: column; height: 100%; width: 100%; align-items: center; justify-content: center;">
                <h3 style="font-size: 28px;font-weight: 600;color: #fff;text-shadow: 1px 1px #000;">{{ $details->announcement_title ?? 'No announcement yet' }}</h3>
                <span style="color: #fff;">{{ !empty($details->announcement_description) ? $details->announcement_description : 'No description' }}</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>