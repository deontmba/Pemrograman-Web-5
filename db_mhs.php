

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mhs";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected";

$sql = "CREATE DATABASE mhs";
if ($conn->query($sql) === true){
    echo "Database created successfully";
}
else {
    echo "Error creating database" .$conn->error;
}

$sql = "CREATE TABLE identitas (npm varchar (12), nama varchar(40), alamat varchar (100),
tgl_lhr date, jk char(1), email varchar(50))";

if ($conn->query($sql) === true){
    echo "Tabel identitas berhasil dibuat";
}
else {
    echo "Gagal membuat tabel" .$conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tgl_lhr = $_POST['tgl_lhr'];
    $jk = $_POST['jk'];
    $email = $_POST['email'];
    $action = $_POST['action'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "insert" || $action == "update") {
        $npm = $_POST['npm'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $tgl_lhr = $_POST['tgl_lhr'];
        $jk = $_POST['jk'];
        $email = $_POST['email'];
        
        if ($action == "insert") {
            // Insert data
            $sql = "INSERT INTO identitas (npm, nama, alamat, tgl_lhr, jk, email)
                    VALUES ('$npm', '$nama', '$alamat', '$tgl_lhr', '$jk', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($action == "update") {
            // Update data
            $sql = "UPDATE identitas SET nama='$nama', alamat='$alamat', tgl_lhr='$tgl_lhr', jk='$jk', email='$email'
                    WHERE npm='$npm'";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    } elseif ($action == "tampil") {
        // Display data
        $sql = "SELECT npm, nama, alamat, tgl_lhr, jk, email FROM identitas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Data Mahasiswa</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["npm"] . "</td>
                        <td>" . $row["nama"] . "</td>
                        <td>" . $row["alamat"] . "</td>
                        <td>" . $row["tgl_lhr"] . "</td>
                        <td>" . $row["jk"] . "</td>
                        <td>" . $row["email"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    }
}

$conn->close();

?>