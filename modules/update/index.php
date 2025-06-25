<?php
include '../../config/version.php';
session_start();
if (!isset($_SESSION['login'])) header("Location: ../../login.php");

$repo = "Hanafis09/mcu-klinik";
$latest = json_decode(file_get_contents("https://api.github.com/repos/$repo/releases/latest"), true);

// GitHub API memerlukan user-agent
$options = ['http' => ['header' => "User-Agent: Kirana-Updater"]];
$context = stream_context_create($options);
$response = file_get_contents("https://api.github.com/repos/$repo/releases/latest", false, $context);
$latest = json_decode($response, true);

$versi_terbaru = $latest['tag_name'] ?? 'unknown';
$log = $latest['body'] ?? 'Tidak ada catatan rilis.';
$zip_url = $latest['zipball_url'] ?? '#';

?>

<h2>Update Sistem - Kirana</h2>
<p><strong>Versi Saat Ini:</strong> <?= $VERSI_SISTEM ?></p>
<p><strong>Versi Terbaru:</strong> <?= $versi_terbaru ?></p>

<h3>Changelog:</h3>
<pre><?= $log ?></pre>

<?php if ($versi_terbaru !== $VERSI_SISTEM && $zip_url != '#') { ?>
  <form method="post" action="updater.php">
    <input type="hidden" name="url" value="<?= $zip_url ?>">
    <button type="submit">⬇️ Update Sekarang</button>
  </form>
<?php } else { ?>
  <p>✅ Sistem Anda sudah versi terbaru.</p>
<?php } ?>

<a href="../../index.php">← Kembali ke Dashboard</a>