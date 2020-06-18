Mengonfirmasir Masuk Secara Manual

Facebook Login
Ringkasan
ioS
Android
Web
Untuk Perangkat
Praktik Terbaik
Desain Pengalaman Pengguna
Keamanan Login
Izin
Token Akses
Authentication Versus Data Access
Tes
Tinjauan Aplikasi
Lanjutan
Membuat Alur Masuk Secara Manual
Menggunakan dengan Sistem Masuk yang Ada
Autentikasi Ulang
API Pencocokan ID
Catatan Perubahan
Business Login for Direct Businesses
Membuat Alur Masuk Secara Manual
Untuk aplikasi seluler, gunakan Facebook SDK untuk [iOS](https://developers.facebook.com/docs/facebook-login/login-flow-for-ios/) dan [Android](https://developers.facebook.com/docs/facebook-login/android) dan ikuti panduan terpisah untuk platform ini.

Namun, jika Anda ingin menerapkan masuk berbasis browser untuk sebuah aplikasi desktop tanpa menggunakan SDK kami, seperti webview untuk aplikasi desktop native (misalnya Windows 8), atau alur masuk yang menggunakan kode server secara keseluruhan, Anda dapat membangun alur Masuk untuk Anda sendiri menggunakan pengalihan browser. Panduan ini akan membawa Anda melalui setiap langkah alur masuk dan menunjukkan cara melakukan setiap langkah tanpa menggunakan SDK kami:

- [Memeriksa status masuk](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#checklogin)
- [Memasukkan orang](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#login)
- [Mengonfirmasi identitas](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#confirm)
- [Menyimpan token akses dan status masuk](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#token)
- [Mengeluarkan orang](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#logout)
- [Mendeteksi Saat Orang Menghapus Pemasangan Aplikasi](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#deauth-callback)

Untuk menggunakan Facebook Login di aplikasi desktop, Anda harus menyematkan browser web (kadang disebut webview) dalam aplikasi untuk melakukan proses masuk.

**Memeriksa Status Masuk**

Aplikasi yang menggunakan SDK kami dapat memeriksa apakah seseorang sudah masuk dengan menggunakan fungsi bawaan. Semua aplikasi lain harus [membuat cara penyimpanan sendiri](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow#token) ketika orang sudah masuk, dan ketika tidak ada indikator, lanjutkan dengan asumsi bahwa mereka sudah keluar. Jika seseorang keluar, maka aplikasi Anda harus mengarahkannya ke dialog Masuk pada waktu yang tepat — misalnya, jika dia mengklik tombol masuk.

Memasukkan Orang
Baik orang tidak masuk ke aplikasi Anda atau tidak masuk ke Facebook, Anda dapat menggunakan dialog Masuk untuk memintanya melakukan keduanya. Jika mereka tidak masuk ke Facebook, mereka akan diminta untuk masuk, lalu berlanjut masuk ke aplikasi Anda. Hal ini dideteksi secara otomatis, jadi Anda tidak perlu melakukan tindakan lain untuk mengaktifkan perilaku ini.

	

Meminta [Dialog Masuk](https://developers.facebook.com/docs/facebook-login/overview/#logindialog) dan Mengatur URL Pengalihan
Aplikasi Anda harus memulai pengalihan ke endpoint yang akan menampilkan dialog masuk:

```javascript
https://www.facebook.com/v7.0/dialog/oauth?
  client_id={app-id}
  &redirect_uri={redirect-uri}
  &state={state-param}
```

Endpoint ini mempunyai parameter wajib berikut ini:

client_id. ID aplikasi Anda, ditemukan di dasbor aplikasi.
redirect_uri. URL yang Anda inginkan untuk mengalihkan orang kembali masuk. URL ini akan menerima tanggapan dari Dialog Masuk. Jika Anda menggunakan ini pada webview dalam aplikasi desktop, URL ini harus diatur ke

```javascript
 https://www.facebook.com/connect/login_success.html.
```

 Anda dapat mengonfirmasi bahwa URL ini ditetapkan untuk aplikasi Anda di Dasbor Aplikasi. Di bagian Produk di menu navigasi sebelah kiri Dasbor Aplikasi, klik Facebook Login, lalu klik Pengaturan. Verifikasi URI pengarahan ulang OAuth Valid di bagian Pengaturan OAuth Klien.
state. Sebuah nilai string yang dibuat oleh aplikasi Anda untuk mempertahankan status antara permintaan dan callback. Parameter ini harus digunakan untuk mencegah Cross-site Request Forgery dan akan diteruskan kembali ke Anda, tidak diubah, di URI pengalihan Anda.
Misalnya, jika permintaan masuk Anda terlihat seperti:

```javascript   
https://www.facebook.com/v7.0/dialog/oauth?
  client_id={app-id}
  &redirect_uri={"https://www.domain.com/login"}
  &state={"{st=state123abc,ds=123456789}"}
```

maka URI pengalihan Anda akan dipanggil dengan:

```javascript
https://www.domain.com/login?state="{st=state123abc,ds=123456789}"
```  

URL ini juga mempunyai parameter opsional berikut ini:

response_type. Menentukan apakah data tanggapan yang disertakan ketika terjadi pengalihan kembali ke aplikasi terjadi di parameter atau di fragmen URL. Lihat bagian Mengonfirmasi Identitas untuk memilih jenis yang harus digunakan aplikasi Anda. Ini dapat merupakan salah satu dari:
code. Data tanggapan disertakan sebagai parameter URL dan berisi parameter code (string terenkripsi yang unik untuk masing-masing permintaan masuk). Ini adalah perilaku default jika parameter ini tidak ditentukan. Perilaku ini sangat berguna ketika server Anda akan menangani token.
token. Data tanggapan disertakan sebagai fragmen URL dan berisi token akses. Aplikasi desktop harus menggunakan pengaturan ini untuk response_type. Ini sangat berguna ketika klien akan menangani token.
code%20token. Data tanggapan disertakan sebagai fragmen URL dan berisi token akses dan parameter code.
granted_scopes. Menghasilkan daftar yang dipisahkan oleh koma berisi semua Izin yang diberikan ke aplikasi oleh pengguna pada saat masuk. Dapat digabungkan dengan nilai response_type lain. Ketika digabungkan dengan token, data tanggapan disertakan sebagai fragmen URL, jika tidak disertakan sebagai parameter URL.
scope. Daftar Izin yang dipisahkan oleh koma atau spasi untuk permintaan dari orang yang menggunakan aplikasi Anda.
Untuk Aplikasi Windows 8
Jika Anda membangun alur Masuk untuk aplikasi Windows, Anda dapat menggunakan Pengidentifikasi Keamanan Paket sebagai redirect_uri Anda. Picu Dialog Masuk dengan memanggil WebAuthenticationBroker.AuthenticateAsync dan gunakan endpoint Dialog Masuk sebagai requestUri. Berikut adalah contoh di JavaScript:

```javascript
var requestUri = new Windows.Foundation.Uri(
  "https://www.facebook.com/v7.0/dialog/oauth?
    client_id={app-id}
    &display=popup
    &response_type=token
    &redirect_uri=ms-app://{package-security-identifier}");

Windows.Security.Authentication.Web.WebAuthenticationBroker.authenticateAsync(
  options,
  requestUri)
  .done(function (result) {
    // Handle the response from the Login Dialog
  }
);
```

Ini akan mengembalikan alur kontrol kembali ke aplikasi Anda dengan token akses jika berhasil, atau kesalahan jika gagal.

Menangani Tanggapan Dialog Masuk
Pada titik di alur masuk ini, orang akan melihat dialog Masuk dan akan mempunyai pilihan untuk membatalkan atau mengizinkan aplikasi mengakses data mereka.

Jika seseorang yang menggunakan aplikasi memilih OK di dialog Masuk, berarti mereka memberi akses ke profil publik, daftar teman mereka, dan berbagai Izin lainnya yang diminta oleh aplikasi Anda.

Pada hampir semua kejadian, browser kembali ke aplikasi, dan data tanggapan yang menunjukkan seseorang yang terhubung atau dibatalkan akan disertakan. Saat aplikasi Anda menggunakan metode pengalihan seperti di atas, redirect_uri tujuan kembali aplikasi Anda akan ditambahkan dengan parameter atau fragmen URL (sesuai response_type yang dipilih), yang harus diterima.

Karena berbagai kombinasi bahasa kode yang dapat digunakan di aplikasi web, panduan kami tidak memberikan contoh spesifik. Namun demikian, bahasa terbaru akan mampu mengurai URL, seperti berikut ini:

JavaScript sisi klien dapat menangkap fragmen URL (misalnya jQuery BBQ), sedangkan parameter URL dapat ditangkap baik oleh kode sisi server maupun kode sisi klien (misalnya $_GET di PHP, jQuery.deparam di jQuery BBQ, querystring.parse di Node.js atau urlparse di Python). Microsoft menyediakan panduan dan kode contoh untuk aplikasi Windows 8 yang menghubungkan dengan "penyedia online" - dalam kasus ini adalah Facebook.

Ketika menggunakan aplikasi desktop dan masuk, Facebook mengalihkan orang ke redirect_uri yang disebutkan di atas dan menempatkan token akses bersama dengan beberapa metadata lain (seperti waktu kedaluwarsa token) di fragmen URI:

```javascript
https://www.facebook.com/connect/login_success.html#
    access_token=ACCESS_TOKEN...
```

Aplikasi Anda harus mendeteksi pengalihan ini, lalu membaca token akses di luar URI menggunakan mekanisme yang disediakan oleh OS dan kerangka kerja pengembangan yang Anda gunakan. Berikutnya, Anda dapat melanjutkan ke langkah Memeriksa token akses.


Masuk yang Dibatalkan
Jika orang yang menggunakan aplikasi Anda tidak menerima dialog Masuk dan mengklik Batal, mereka akan dialihkan ke:

```javascript
YOUR_REDIRECT_URI?
 error_reason=user_denied
 &error=access_denied
 &error_description=Permissions+error.
```

Lihat cara Menangani Izin yang Hilang untuk informasi selengkapnya tentang apa yang harus dilakukan aplikasi ketika orang menolak masuk.

Mengonfirmasi Identitas
Karena alur pengalihan ini melibatkan browser yang dialihkan ke URL di aplikasi Anda dari dialog Masuk, maka lalu lintas dapat langsung mengakses URL ini dengan fragmen atau parameter buatan. Jika aplikasi Anda menganggap parameter ini sebagai parameter yang valid, maka aplikasi Anda akan menggunakan data buatan untuk tujuan yang berpotensi jahat. Sebagai hasilnya, aplikasi Anda harus mengonfirmasi bahwa orang yang menggunakan aplikasi tersebut adalah orang yang sama yang data tanggapannya Anda miliki sebelum membuat token akses untuknya. Konfirmasi identitas diselesaikan dengan berbagai cara, bergantung pada response_type yang diterima di atas:

Ketika code diterima, kode itu harus ditukar dengan token akses yang menggunakan endpoint. Panggilan ini harus dari server ke server, karena melibatkan kunci rahasia aplikasi Anda. (Kunci rahasia aplikasi Anda tidak akan pernah menjadi kode klien.)
Ketika token diterima, token itu harus diverifikasi. Anda harus membuat panggilan API untuk memeriksa endpoint yang akan mengindikasikan untuk siapa token dibuat dan oleh aplikasi apa. Karena panggilan API ini harus menggunakan token akses aplikasi, jangan pernah membuat panggilan dari klien. Tetapi, buatlah panggilan ini dari server yang Anda gunakan untuk menyimpan kunci rahasia aplikasi Anda dengan aman.
Ketika code dan token diterima, kedua langkah tersebut harus dilakukan.
Perhatikan bahwa Anda juga dapat membuat parameter state Anda sendiri dan menggunakannya dengan permintaan masuk Anda untuk memberikan perlindungan CSRF.

Mengganti Kode dengan Token Akses
Untuk mendapat token akses, buat permintaan HTTP GET pada endpoint OAuth berikut ini:

```javascript
GET https://graph.facebook.com/v7.0/oauth/access_token?
   client_id={app-id}
   &redirect_uri={redirect-uri}
   &client_secret={app-secret}
   &code={code-parameter}
```

Endpoint ini mempunyai beberapa parameter wajib berikut:

client_id. ID aplikasi Anda
redirect_uri. Argumen ini dibutuhkan dan harus sama dengan request_uri asli yang Anda gunakan saat memulai proses masuk OAuth.
client_secret. Kunci rahasia aplikasi unik Anda ditampilkan di Dasbor Aplikasi. Kunci rahasia aplikasi ini tidak akan disertakan di kode pihak klien atau di biner yang dapat didekompilasi. Sangat penting untuk diperhatikan bahwa rahasia tersebut tetap benar-benar rahasia karena merupakan inti keamanan aplikasi Anda dan semua orang yang menggunakannya.
code. Parameter tersebut diterima dari pengalihan Dialog Masuk di atas.
Catatan: Mulai v2.3 ke atas, endpoint ini akan mengembalikan tanggapan JSON yang tepat. Jika panggilan Anda tidak menentukan versinya, maka secara default versi yang ditentukan adalah versi paling lama yang tersedia.

Tanggapan

Tanggapan yang akan Anda terima dari endpoint ini akan dikembalikan dalam format JSON dan, jika berhasil:

```javascript
{
  "access_token": {access-token}, 
  "token_type": {type},
  "expires_in":  {seconds-til-expiration}
}
```

Jika tidak berhasil, Anda akan menerima pesan penjelasan kesalahan.

Memeriksa Token Akses
Baik aplikasi Anda menggunakan code atau token sebagai response_type Anda dari Dialog masuk atau tidak, token akses akan tetap diterima. Anda dapat melakukan pemeriksaan otomatis pada token tersebut menggunakan endpoint API Graf:

```javascript
GET graph.facebook.com/debug_token?
     input_token={token-to-inspect}
     &access_token={app-token-or-admin-token}
```

Endpoint ini mengambil parameter berikut:

input_token. Token yang harus Anda periksa.
access_tokenToken akses aplikasi atau token akses aplikasi untuk developer aplikasi.
Tanggapan panggilan API adalah susunan JSON yang berisi data tentang token yang diperiksa. Misalnya:

```javascript
{
    "data": {
        "app_id": 138483919580948, 
        "type": "USER",
        "application": "Social Cafe", 
        "expires_at": 1352419328, 
        "is_valid": true, 
        "issued_at": 1347235328, 
        "metadata": {
            "sso": "iphone-safari"
        }, 
        "scopes": [
            "email", 
            "publish_actions"
        ], 
        "user_id": "1207059"
    }
}
```

Kolom app_id dan user_id membantu aplikasi Anda memverifikasi bahwa token akses valid untuk orang tersebut dan untuk aplikasi Anda. Untuk deskripsi lengkap kolom lainnya, lihat Mendapatkan Info tentang panduan Token Akses.

Memeriksa Izin
Edge /me/permissions dapat dipanggil untuk mengambil data daftar izin yang sudah diberikan atau ditolak oleh pengguna tertentu. Aplikasi Anda dapat menggunakannya untuk memeriksa permintaan izin mana yang tidak dapat digunakan oleh pengguna tertentu.

Meminta kembali Izin yang Ditolak
Dengan Facebook Login, orang dapat menolak membagikan izin dengan aplikasi Anda. Dialog Login berisi layar yang terlihat seperti ini:


Izin public_profile selalu diperlukan dan berwarna abu-abu karena tidak dapat dinonaktifkan.

Namun, jika seseorang tidak memeriksa user_likes (Suka) dalam contoh ini, maka dengan memeriksa /me/permissions yang izinnya sudah diberikan akan menghasilkan:

```javascript
{
  "data":
    [
      {
        "permission":"public_profile",
        "status":"granted"
      },
      {
        "permission":"user_likes",
        "status":"declined"
      }
    ]
}
```

Perhatikan bahwa user_likes sudah ditolak, dan bukan diberikan.

Tidak mengapa jika meminta seseorang lagi untuk memberikan izin bagi aplikasi Anda yang pernah ditolak. Anda seharusnya memiliki layar edukasi tentang mengapa mereka sebaiknya memberikan izin kepada Anda, kemudian meminta ulang. Tetapi, jika Anda meminta Dialog Masuk seperti sebelumnya, maka layar ini tidak akan meminta izin tersebut.

Ini karena setelah seseorang menolak izin, Dialog Login tidak akan meminta ulang orang tersebut kecuali Anda secara tegas memberitahukan dialog bahwa Anda meminta ulang izin yang ditolak.

Anda dapat melakukannya dengan menambahkan parameter auth_type=rerequest di URL Dialog Masuk Anda:

```javascript
https://www.facebook.com/v7.0/dialog/oauth?
    client_id={app-id}
    &redirect_uri={redirect-uri}
    &auth_type=rerequest
    scope=email
``` 

Dengan menggunakan ini, Dialog Masuk akan meminta ulang untuk izin yang ditolak.

Menyimpan Token Akses dan Status Masuk
Pada titik ini di alur, Anda sudah mengautentikasi dan memasukkan seseorang. Aplikasi Anda siap melakukan panggilan API atas namanya. Sebelum melakukannya, aplikasi harus menyimpan token akses dan status masuk dari orang yang menggunakan aplikasi tersebut.

Menyimpan Token Akses
Setelah aplikasi Anda menerima token akses dari langkah sebelumnya, token tersebut harus disimpan agar tersedia untuk semua komponen aplikasi saat melakukan panggilan API. Di sini tidak ada proses khusus, namun pada umumnya jika Anda membuat aplikasi web, sebaiknya menambahkan token sebagai variabel sesi untuk mengidentifikasi sesi browser dengan orang tertentu, jika Anda membuat desktop native atau aplikasi seluler, maka Anda harus menggunakan datastore yang tersedia untuk aplikasi Anda. Selain itu, aplikasi akan menyimpan token di database bersama dengan user_id untuk mengidentifikasinya.

Lihat catatan kami tentang ukuran token akses di dokumen token akses.

Melacak status masuk
Sekali lagi, aplikasi Anda akan menyimpan status masuk seseorang, yang membantu menghindari harus melakukan panggilan tambahan ke dialog Masuk. Apa pun prosedur yang Anda pilih, ubah pemeriksaan status masuk Anda untuk mengetahuinya.

Mengeluarkan Orang
Anda dapat mengeluarkan orang dari aplikasi Anda dengan membatalkan indikator status masuk yang Anda tambahkan, contohnya menghapus sesi yang mengindikasikan seseorang masuk. Anda juga harus menghapus token akses yang tersimpan.

Mengeluarkan seseorang tidak sama dengan membatalkan izin masuk (menghapus autentikasi yang sebelumnya diberikan), yang dapat dilakukan secara terpisah. Karena itu, maka buat aplikasi Anda sehingga tidak otomatis memaksa orang yang sudah keluar kembali ke dialog Masuk.

Mendeteksi Saat Orang Menghapus Pemasangan Aplikasi
Orang-orang dapat menghapus pemasangan aplikasi melalui Facebook.com tanpa berinteraksi dengan aplikasi itu sendiri. Untuk membantu aplikasi mendeteksi saat ini terjadi, kami memungkinkan aplikasi menyediakan URL batalkan otorisasi callback yang akan di-ping setiap kali ini terjadi.

Anda dapat mengaktifkan batalkan otorisasi callback melalui Dasbor Aplikasi. Cukup buka aplikasi Anda, lalu pilih Produk, lalu Facebook Login, dan terakhir Pengaturan. Bidang teks disediakan untuk URL Batalkan Otorisasi Callback.

Setiap kali pengguna aplikasi Anda membatalkan otorisasinya, URL ini akan dikirimi HTTP POST yang berisi permintaan yang ditandatangani. Baca panduan kami untuk menguraikan permintaan yang ditandatangani untuk melihat cara mendekodekan ini guna menemukan ID pengguna yang memicu callback tersebut.

Menanggapi Permintaan untuk Menghapus Data Pengguna
Orang dapat meminta aplikasi untuk menghapus semua informasi tentang mereka yang diterima dari Facebook. Untuk menanggapi permintaan ini, lihat Callback Permintaan Penghapusan Data.


Produk
Kecerdasan Buatan
AR/VR
Alat Bisnis
Game
Sumber Terbuka
Penerbitan
Integrasi Sosial
Kehadiran Sosial
Program
Developer Circles
F8
Program Perusahaan Rintisan
ThreatExchange
Dukungan
Dukungan Developer
Bug
Status Platform
Grup Komunitas Facebook for Developers
Berita
Blog
Kisah Sukses
Video
Halaman Facebook for Developers
Ikuti Kami
Ikuti Kami di FacebookIkuti Kami InstagramIkuti Kami di TwitterIkuti Kami di LinkedInIkuti Kami di YouTube
© 2020 Facebook
Tentang
Buat Iklan
Karier
Kebijakan Platform
Kebijakan Privasi
Cookie
Ketentuan

Bahasa Indonesia

Bahasa Indonesia
Apakah dokumen ini membantu ?
YaYa, tapi...Tidak
Hapus
