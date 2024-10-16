<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rating</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: transparent;
        }
        .rating-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .stars, .average-stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin: 10px 0;
        }
        .stars i {
            font-size: 20px;
            color: #d3d3d3;
            cursor: pointer;
            margin-bottom:10px;
        }
        .average-stars i {
            font-size: 30px;
            color: #d3d3d3;
        }
        .stars i.active, .stars i.hover, .average-stars i.active {
            color: #f39c12;
        }
        .rating-result {
            font-size: 1.5em;
            margin: 10px 0;
        }
        .total-reviews {
            color: grey;
        }
        hr {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="rating-box">
        <h2>Rating</h2>
        <p>Berikan Rating ke Website {{$nama}} ATR/BPN</p>
        <div class="stars">
            <i class="fa fa-star" data-value="1"></i>
            <i class="fa fa-star" data-value="2"></i>
            <i class="fa fa-star" data-value="3"></i>
            <i class="fa fa-star" data-value="4"></i>
            <i class="fa fa-star" data-value="5"></i>
        </div>
        <div class="average-stars">
            <i class="fa fa-star" data-value="1"></i>
            <i class="fa fa-star" data-value="2"></i>
            <i class="fa fa-star" data-value="3"></i>
            <i class="fa fa-star" data-value="4"></i>
            <i class="fa fa-star" data-value="5"></i>
        </div>
        <input type="hidden" id="nilai" value="{{$rating->rating}}">
        <input type="hidden" id="appid" value="{{$appid}}">
        <div class="rating-result">{{round($rating->rating, 2)}}</div>
        <p class="total-reviews">({{$rating->jumlah}} reviews)</p>
        <p>out of 5</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let ratingValue = 0;
            let averageRating =roundToTwo(parseFloat($('#nilai').val())); // Nilai rata-rata rating awal

            // Fungsi untuk mengupdate bintang rata-rata rating
            function updateAverageStars(average) {
                $('.average-stars i').each(function () {
                    const starValue = $(this).data('value');
                    if (starValue <= Math.floor(average)) {
                        $(this).addClass('active');
                    } else if (starValue === Math.ceil(average) && !Number.isInteger(average)) {
                        $(this).addClass('active');
                        $(this).css('clip-path', `inset(0 ${100 - (average % 1) * 100}% 0 0)`);
                    } else {
                        $(this).removeClass('active');
                    }
                });
            }

            // Memanggil fungsi untuk mengupdate bintang rata-rata
            updateAverageStars(averageRating);

            $('.stars i').on('mouseover', function () {
                const hoverValue = $(this).data('value');
                $('.stars i').each(function () {
                    if ($(this).data('value') <= hoverValue) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });
            });

            $('.stars i').on('mouseout', function () {
                $('.stars i').removeClass('hover');
            });

            function roundToTwo(num) {
                return Math.round(num * 100) / 100;
            }

            $('.stars i').on('click', function () {
                ratingValue = $(this).data('value');
                $('.stars i').removeClass('active');
                $('.stars i').each(function () {
                    if ($(this).data('value') <= ratingValue) {
                        $(this).addClass('active');
                    }
                });

                const appid = $('#appid').val();

                // Kirim data rating ke server menggunakan jQuery AJAX
                $.ajax({
                    url: '/submit-rating',
                    method: 'POST',
                    data: {
                        rating: ratingValue,
                        appid: appid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                       // alert('Rating berhasil dikirim! Terima kasih!');
                        //console.log(response);

                        // Update nilai dan jumlah rating di 
                        var rate = roundToTwo(response.rating)
                        console.log(rate);
                        $('.stars').hide();
                        $('#nilai').val(rate);
                        $('.rating-result').text(rate);
                        $('.total-reviews').text(`(${response.jumlah} reviews)`);

                        // Update tampilan bintang rata-rata
                        updateAverageStars(rate);
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Terjadi kesalahan saat mengirim rating.');
                    }
                });
            });
        });
    </script>
</body>
</html>

