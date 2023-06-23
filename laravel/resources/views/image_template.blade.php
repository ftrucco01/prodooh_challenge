<!DOCTYPE html>
<html>
<head>
<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: {{ $dimensions['width'] }}px;
  height: {{ $dimensions['height'] }}px;
  position: relative; /*1920x1080, 1280x720 o 720x480 */
  border: 1px solid #777
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

div.avatar {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 100px;
  height: 100px;
}
</style>
</head>
<body>

<div class="gallery">
  <img src="{{ $background }}" alt="Cinque Terre">
  <div class="desc">{{ $phrase }}</div>
  <div class="avatar">
    <img src="{{ $avatar }}" alt="Avatar">
  </div>
</div>

@if (!$isPrinting)
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    var createImageUrl = "{{ url('api/create/images') }}";
    var loginUrl = "{{ url('api/login') }}";
    var dimensions = "{{ $dimensions['width'] }}x{{ $dimensions['height'] }}";
    var phraseId = {{$phraseId}};

  </script>
  <script src="{{ asset('js/custom.js') }}"></script>
@endif

</body>
</html>