<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SLI-03</title>

    <!-- Css -->
    <style>
        .main-area {
            margin-left: 3rem;
            width: 80%;
            justify-content: center;
        }

        .main-area .detailStud {
            width: 50rem;
        }

        .main-area p {
            margin: 0cm;
            font-size: 16px;
            font-family: "Arial", sans-serif;
        }

        .main-area span {
            font-size: 16px;
            font-family: "Arial", sans-serif;
        }

        .main-area b {
            display: inline-block;
            width: 24%;
            position: relative;
            padding-right: 10px;
            /* Ensures colon does not overlay the text */
        }

        .main-area b::after {
            content: ":";
            position: absolute;
            right: 10px;
            padding-bottom: 1rem;
        }

        .ref {
            font-size: 16px;
            font-family: "Arial", sans-serif;
            margin-left: -6rem;
            margin-bottom: 2rem;
            margin-top: .5rem;
        }

        .ref p {
            font-size: 16px;
            font-family: "Arial", sans-serif;
        }

        .banner {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="banner">
        <img src={{ asset('img/2.png') }} alt="banner" height="150rem" width="690rem">
    </div>
    <div class="ref">
        <p style='margin:0cm;margin-right:.2pt;'><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; REF&nbsp; &nbsp;:</span><span>&nbsp;100
                &ndash; KJM(FSKM 14/3/4/5)</span></p>
        <p style='margin:0cm;margin-right:.2pt;'><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; DATE : 21<sup>st</sup> JUNE 2022</span></p>
    </div>
    <div class="main-area">
        <p style='margin-top:12.0pt;'><span>{{ $user->interndata->companyName }}</span></p>
        <p><span>20-2 Jalan Suria Puchong 6, Pusat Perniagaan Suria</span></p>
        <p><span>Puchong,47110 Puchong, Selangor</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>u/p: {{ $user->interndata->personinCharge }}</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>Tuan/Puan,</span></p>
        <p><span>&nbsp;</span></p>
        <p style='margin-top:12.0pt;'><strong><span>PENERIMAAN TAWARAN MENJALANI LATIHAN INDUSTRI </span></strong></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <div class="detailStud">
            <p style='margin-right:.2pt;text-align:justify;'>
                <strong><span><b>NAMA PELAJAR</b>{{ $user->fullname }}</span></strong>
            </p>
            <p style='margin-right:.2pt;text-align:justify;'>
                <strong><span><b>NO UITM</b>{{ $user->student_number }}</span></strong>
            </p>
            <p style='text-align:justify;'><strong><span><b>PROGRAM</b>{{ $user->program->name }}</span></strong>
            </p>
            <p><strong><span style='color:black;'><b>INSTITUSI</span></strong></b><strong>Universiti Teknologi Mara (UiTM)</strong></p>
        </div>
        <p style='margin-top:20.0pt;'><span>Dengan hormatnya perkara di atas dirujuk.</span></p>
        <p><span style='color:black;'>&nbsp;</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>2.&nbsp;&nbsp;Sukacita dimaklumkan pelajar bernama {{ $user->fullname }},
            (No K/P {{ $user->ic }}) telah menerima tawaran sebagai pelatih industri dengan
            butiran seperti berikut:</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <div class="detailStud">
            <p style='margin-right:.2pt;text-align:justify;'>
                <span><b>TEMPAT LATIHAN</b><strong>{{ $user->interndata->companyName }}</span></strong>
            </p>
            <p style='margin-right:.2pt;text-align:justify;'>
                <strong><span><b>TARIKH LATIHAN</b>{{ $user->interndata->periodDuty }}</span></strong>
            </p>
            <p style='text-align:justify;'><strong><span><b>TARIKH LAPOR DIRI</b>{{ $user->interndata->dateDuty }}</span></strong>
            </p>
        </div>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>3.&nbsp;&nbsp;Pelatih adalah tertakluk kepada polisi dan peraturan organisasi sepanjang tempoh
            latihan. Setiap pelatih akan diselia oleh seorang Penyelia Industri yang dilantik sepanjang
            tempoh latihan. Pelatih harus membuat tugas latihan mengikut skop bidang kursus seperti di Lampiran 1.&nbsp;</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>4.&nbsp;&nbsp; Kehadiran pelatih ke tempat latihan mestilah melebihi 80% kehadiran. Pelatih tidak
            dibenarkan mengambil cuti sewaktu menjalani latihan kecuali dengan kelulusan organisasi
            yang berkaitan. Sekiranya terdapat permohonan cuti yang melibatkan aktiviti-aktiviti
            akademik/universiti, pihak organisasi akan merujuk kepada pihak universiti untuk tujuan
            kelulusan. Setiap pelatih industri dilindungi oleh Skim Perkhidmatan Kesihatan Pelajar
            UiTM mengikut tarikh latihan yang telah di tetapkan oleh pihak UiTM.</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>5.&nbsp;&nbsp;Bersama-sama ini disertakan Borang Lapor Diri (BLI-04) untuk diisi dan
            dikembalikan kepada pihak UiTM selepas satu minggu dari tarikh pelatih melapor diri. </span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>Kami amat menghargai segala tunjuk ajar dari pihak tuan/puan semasa beliau menjalani
            latihan ini. Pihak kami juga berharap agar pelatih dapat menyumbang kepada
            pembangunan organisasi pihak tuan/puan.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>Sekian. Terima kasih.</span></p>
        <p><strong><span>&nbsp;</span></strong></p>
        <p><span>Yang benar,</span></p>
        <p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIsAAABeCAMAAAAkNBdRAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAzUExURf///93d3ZmZme7u7iIiIgAAAKurq2ZmZhERETMzM1VVVYiIiLu7u8zMzHd3d0RERAAAAHdk2HIAAAARdFJOU/////////////////////8AJa2ZYgAAAAlwSFlzAAAh1QAAIdUBBJy0nQAABH5JREFUaEPtmW13qyAQhIOIIr79/397nwGSWk3v6YcAfuj0RUJ6jpNldnbXPv7whz/8H6azedUevRvyqj3cfbjYG3EZ78Nl8M51ed0YZnK3icsAlbtwCVCZTH7RGKjFzXndGB1U/E1sV8p1ed0IdkznsjjvnY/LZiB74nV0fWjNBa/VZe3dNrfmQvbognLXubFelD26Ti48trZxWWUqXA1hscFNabcJYgkSl81NlhctrY4Tgg2L3o2W2LSsAKg15jQ0BrK7qVyeXDrXL5zTnrebAC6LuOxut6RSJbnYt1J4xkUZjdMsebswwrTm1QFkTi8uBtPVOVWS7tuODf9fxIUC0Ck2dTqGlbvm5RfI6C3WxsW7lVSq03dbXOTKpZdixaXzzsxKpRpAo1cuRINIiIsK0VipAJgdLhe9dM7DDy52xFmC6/N+WajDv8aF7onf4iJnqVQYEa6MJL96wmJwXOBicBb1Umm/LHARpvZzXGIiRy5wlaKquIvGnmtcMH/dHdWISwpSeSQu57gogQC6hYu+425ZWML/Li6Zy+5miJBFNUwXdyV3f4oLQqLnptOsMjLCBY3+FBcaKPpcoQIX2T+Xa1xCVOvkRmpBJS6oRfe8xiVWAPY75FKFi90SlWtcdDhc4MKfVOBiO8K/y0XoCE5c9tiuIN1ZRwSfolzMTEn0W7TTzfUn/0jtChziiMRJluQS0yMGhXWvhvYbIhf2+6Tcgv5i1pUGcsqNPXbnT9LlcOAyeJepvGuHP4M1Bn7Mr9RbT6ePvYgdodM8DcI54z+Dde+neIcvheQyeATNi9G+njOAQgekHg74ztrnHeI89h0TqY5aJnQDzmL6FJKjJ2S9XLksPe+NqVAdDvPTMENEpORDCLN9w4UcXuPDBTSsyaQsOKGsheXKRe+oCmzEBtToLudJ+TTI6fJOAtzgopkEPwZVOt3HTEYtGsqOeUSnKy5KpSQuOXBxiIpfpc9DNztE83EMi0GsunUtaf8PY43lG4Uii9gTfB2SNnPeC6XS+Qn9gyxhIvwpo56fHWbTEGWyKz576ZZbHz0iViEmQgbmbPLYPn4sLsEyz5fvoB729QV2ihEOm9SLSnC23Hi+8ePHOlIvy1QnoDEsW42g5oBp3kdG32dos26pbJdK8tUriYhHQqyYWAvl4evkIuwSlbVv81xKRIhCZcms9DT8xKOKAYHQsRCZAN1+NiUVxPHk1QvQS83L8/NTMKT3/jwrfBpvuMSOk335rV2Gbgt7jEnxpHrLZVSvxyCwhr1PSvJbaadJvpeXL6hA66HM04j6cVvKG436/VOGWqPMUmeuEaAP87n9LIdXc5dgujEfiuDH8gdzwHgc0paQRxAQtq4rW6F/hjXRVD0WouuhiagLa4ZNaUuVlIWwellLZTBYx/ap35aoUwuXbyKqhtxH+vAy1UENQ17XBWWn349GRmNZ6z9FZ9hzuhCWOo/+fwGa3dtwQbm34aKMysvmuBmXZqZ7BlyqDK2/AUfUqCRecX0c3w41hsXfYijfY//hD7fD4/EPpb0jQYmgtNEAAAAASUVORK5CYII="
                style="margin-top: 2rem;width: 78pt; height: 40pt;" alt="image"></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p style='margin-left:36.0pt;text-indent:-36.0pt;'>
            <span>MOHAMAD ASROL BIN ARSHAD</span>
        </p>
        <p style='margin-left:36.0pt;text-indent:-36.0pt;'>
            <span>Penyelaras Latihan Industri CS251 </span>
        </p>
        <p style='margin-left:36.0pt;text-indent:-36.0pt;'>
            <span>Fakulti Sains Komputer dan Matematik </span>
        </p>
        <p style='text-align:justify;'><span>UiTM Cawangan Melaka Kampus Jasin</span></p>
        <p style='text-align:justify;'><span>77300 Merlimau, Melaka</span></p>
        <p><span>Office no: &nbsp;062645575</span></p>
        <p><span>E-mail:mohamad_asrol@uitm.edu.my</span></p>
    </div>
</body>

</html>
