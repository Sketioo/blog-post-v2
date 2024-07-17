<div style="font-family: Arial, sans-serif; color: #333;">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <div class="container mt-4">
      <div class="card">
          <div class="card-header bg-primary text-white">
              <h2>Application Summary</h2>
          </div>
          <div class="card-body">
              <p class="card-text">Hello,</p>
              <p class="card-text">Here is the current summary of your application:</p>
              <ul class="list-group">
                  <li class="list-group-item">Total Users: <strong>{{ $totalUsers }}</strong></li>
                  <li class="list-group-item">Total Posts: <strong>{{ $totalPosts }}</strong></li>
              </ul>
              <p class="card-text mt-4">Thank you for managing your application with us.</p>
          </div>
          <div class="card-footer text-muted">
              <p>Best regards,</p>
              <p>The BlogKita Team</p>
          </div>
      </div>
  </div>
</div>
