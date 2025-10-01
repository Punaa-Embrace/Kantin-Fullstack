<<<<<<< HEAD
test
=======

>>>>>>> 0c481c5db9ca8638aa8ae68b5c33a793b53c6f1a
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')

  <title>Document</title>
</head>
<body>
TODO: dibikin per subfolder admin/dashboard.blade.php, tenant-manager/dashboard.blade.php, dan lain-lain
<form id="logout-form" action="{{ route('logout') }}" method="POST" >
    @csrf

    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="text-sm text-gray-600 hover:text-gray-900">
        Logout
    </button>
    
</form>

</body>
</html>

