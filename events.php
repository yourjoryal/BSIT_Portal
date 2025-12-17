<?php
/* DATABASE CONNECTION */
$conn = mysqli_connect("localhost", "root", "", "bsit_portal");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

/* ADD EVENT */
if (isset($_POST['add_event'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $image = mysqli_real_escape_string($conn, $_POST['image']);

  $insert = "INSERT INTO events (title, event_date, description, image)
             VALUES ('$title', '$event_date', '$description', '$image')";
  mysqli_query($conn, $insert);

  // PREVENT FORM RESUBMISSION
  header("Location: events.php?success=1");
  exit();
}

/* DELETE EVENT */
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  mysqli_query($conn, "DELETE FROM events WHERE id=$id");

  header("Location: events.php");
  exit();
}

/* FETCH EVENTS */
$result = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Events</title>
<link rel="stylesheet" href="public/css/events.css">

<style>
/* SIMPLE ADMIN FORM */
.admin-form {
  background: #fff;
  color: #000;
  padding: 20px;
  max-width: 600px;
  margin: 120px auto 30px;
  border-radius: 8px;
}
.admin-form h2 {
  margin-bottom: 15px;
}
.admin-form input,
.admin-form textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
}
.admin-form button {
  background: #0a1a33;
  color: #fff;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
}
.delete-btn {
  display: inline-block;
  background: crimson;
  color: #fff;
  padding: 6px 12px;
  margin-top: 10px;
  border-radius: 4px;
}
.success {
  text-align: center;
  color: green;
  margin-bottom: 10px;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
  <div class="logo">
    <img src="public/images/bsitlogo.jpg" alt="BSIT Logo">
    <span>BSIT Department</span>
  </div>
  <div class="hamburger">☰</div>
</header>

<!-- SIDE MENU -->
<div id="sideMenu" class="side-menu">
  <a href="homepage.html">Home</a>
  <a href="faculty.html">Faculty</a>
  <a href="organizations.html">Student Organizations</a>
  <a href="announcements.html">Announcements</a>
  <a href="events.php">Events</a>
  <a href="achievements.html">Achievements</a>
  <a href="inquiries.html">Inquiries</a>
</div>

<!-- ADD EVENT FORM -->
<div class="admin-form">
  <h2>Add New Event</h2>

  <?php if (isset($_GET['success'])) { ?>
    <p class="success">Event added successfully!</p>
  <?php } ?>

  <form method="POST">
    <input type="text" name="title" placeholder="Event Title" required>
    <input type="text" name="event_date" placeholder="Event Date (e.g. Jan 31, 2025 · 6:00 PM)" required>
    <textarea name="description" placeholder="Event Description" required></textarea>
    <input type="text" name="image" placeholder="Image filename (e.g. sinulog.jpg)" required>
    <button type="submit" name="add_event">Add Event</button>
  </form>
</div>

<!-- EVENTS LIST -->
<main class="announcements-container">

<?php
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
?>
  <div class="announcement-card">
    <div class="thumb">
      <img src="public/images/<?php echo $row['image']; ?>" alt="Event Image">
    </div>
    <div class="content">
      <h2 class="title"><?php echo $row['title']; ?></h2>
      <p class="date"><?php echo $row['event_date']; ?></p>
      <p class="description"><?php echo $row['description']; ?></p>

      <!-- DELETE BUTTON -->
      <a href="events.php?delete=<?php echo $row['id']; ?>"
         class="delete-btn"
         onclick="return confirm('Are you sure you want to delete this event?');">
         Delete
      </a>
    </div>
  </div>
<?php
  }
} else {
  echo "<p style='text-align:center;'>No events available.</p>";
}
?>

</main>

<footer>
© 2025 BSIT Department - Cebu Technological University Tabuelan Campus
</footer>

<script>
const sideMenu = document.getElementById("sideMenu");
const hamburger = document.querySelector(".hamburger");

hamburger.addEventListener("click", () => {
  sideMenu.classList.toggle("open");
});

document.addEventListener("click", (e) => {
  if (!sideMenu.contains(e.target) && !hamburger.contains(e.target)) {
    sideMenu.classList.remove("open");
  }
});
</script>

</body>
</html>