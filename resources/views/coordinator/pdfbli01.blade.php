<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SLI-01</title>

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

        /* column banner */
        /* .column {
            float: left;
            width: 33.33%;
            height: 1rem;
            margin-left: 0px;
            margin-top: 0px;
        }*/

        /* Clear floats after the columns */
        /* .row:after {
            content: "";
            display: table;
            clear: both;
        } */

        .banner {
            margin-top: 0;
        }
    </style>
</head>

<body>
    {{-- <div class="row">
        <div class="column" style="background-color:#aaa;">
            <h2>Column 1</h2>
            <p>Some text..</p>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h2>Column 2</h2>
            <p>Some text..</p>
        </div>
        <div class="column" style="background-color:#ccc;">
            <h2>Column 3</h2>
            <p>Some text..</p>
        </div>
    </div> --}}
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
        <p><strong><span>TO WHOM IT MAY CONCERN</span></strong></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>Dear Sir/Madam,</span></p>
        <p><span>&nbsp;</span></p>
        <p style='margin-top:12.0pt;'><strong><span>APPLICATION FOR INDUSTRIAL TRAINING
                    PLACEMENT</span></strong></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <div class="detailStud">
            <p style='margin-right:.2pt;text-align:justify;'>
                <strong><span><b>NAME OF STUDENT</b>{{ $user->fullname }}</span></strong>
            </p>
            <p style='margin-right:.2pt;text-align:justify;'>
                <strong><span><b>NRIC</b>{{ $user->ic }}</span></strong>
            </p>
            <p style='text-align:justify;'><strong><span><b>UITM STUDENT
                            NO</b>{{ $user->student_number }}</span></strong>
            </p>
            <p><strong><span style='color:black;'><b>TRAINING
                            SESSION</span></strong></b><strong>{{ $user->semester->session }}</strong></p>
        </div>
        <p><span style='color:black;'>&nbsp;</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>2.&nbsp;&nbsp;We hereby to certify
                that the
                candidate with academic details above is a Final year student of Bachelor of Netcentric
                Computing (Hons.) (CS251) from Faculty of Computer and Mathematical Sciences, UiTM Cawangan
                Melaka Kampus Jasin.</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>3.&nbsp;&nbsp;In partial fulfillment
                of the
                requirements for the curriculum, it is compulsory for the student to undergo an Industrial
                training within the duration of 14 weeks.&nbsp;</span><span>The
                training is expected to begin on <strong>15
                    SEPTEMBER</strong><strong>&nbsp;2022&nbsp;</strong>until<strong>&nbsp;</strong><strong>15</strong><strong>&nbsp;DECEMBER
                    2022.</strong></span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>4.&nbsp;&nbsp;It is a great honour if
                your esteemed
                organisation would accept the student's application for a placement at your company. During the
                training period, it is hoped that the student may be employed full-time at your organisation,
                subject to normal employment rules and regulations of your company.The student may not be
                entitled to receive any holiday/leave without any formal consent from your
                organisation.</span></p>
        <p style='text-align:justify;'><span>&nbsp;</span></p>
        <p style='text-align:justify;'><span style='color:black;'>5.&nbsp;&nbsp;The application
                acceptance will be informed directly to the student by completing the Industrial training acceptance
                form attached. Please send a copy of confirmation letter of employment/mail to UiTM upon the internship
                offer has accepted by student before <strong>26<sup>&nbsp;</sup>AUGUST 2022.</strong></span></p>
        <p><span>&nbsp;</span></p>
        <p><span>Thank you.</span></p>
        <p><strong><span>&nbsp;</span></strong></p>
        <p><span>Sincerely,</span></p>
        <p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIsAAABeCAMAAAAkNBdRAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAzUExURf///93d3ZmZme7u7iIiIgAAAKurq2ZmZhERETMzM1VVVYiIiLu7u8zMzHd3d0RERAAAAHdk2HIAAAARdFJOU/////////////////////8AJa2ZYgAAAAlwSFlzAAAh1QAAIdUBBJy0nQAABH5JREFUaEPtmW13qyAQhIOIIr79/397nwGSWk3v6YcAfuj0RUJ6jpNldnbXPv7whz/8H6azedUevRvyqj3cfbjYG3EZ78Nl8M51ed0YZnK3icsAlbtwCVCZTH7RGKjFzXndGB1U/E1sV8p1ed0IdkznsjjvnY/LZiB74nV0fWjNBa/VZe3dNrfmQvbognLXubFelD26Ti48trZxWWUqXA1hscFNabcJYgkSl81NlhctrY4Tgg2L3o2W2LSsAKg15jQ0BrK7qVyeXDrXL5zTnrebAC6LuOxut6RSJbnYt1J4xkUZjdMsebswwrTm1QFkTi8uBtPVOVWS7tuODf9fxIUC0Ck2dTqGlbvm5RfI6C3WxsW7lVSq03dbXOTKpZdixaXzzsxKpRpAo1cuRINIiIsK0VipAJgdLhe9dM7DDy52xFmC6/N+WajDv8aF7onf4iJnqVQYEa6MJL96wmJwXOBicBb1Umm/LHARpvZzXGIiRy5wlaKquIvGnmtcMH/dHdWISwpSeSQu57gogQC6hYu+425ZWML/Li6Zy+5miJBFNUwXdyV3f4oLQqLnptOsMjLCBY3+FBcaKPpcoQIX2T+Xa1xCVOvkRmpBJS6oRfe8xiVWAPY75FKFi90SlWtcdDhc4MKfVOBiO8K/y0XoCE5c9tiuIN1ZRwSfolzMTEn0W7TTzfUn/0jtChziiMRJluQS0yMGhXWvhvYbIhf2+6Tcgv5i1pUGcsqNPXbnT9LlcOAyeJepvGuHP4M1Bn7Mr9RbT6ePvYgdodM8DcI54z+Dde+neIcvheQyeATNi9G+njOAQgekHg74ztrnHeI89h0TqY5aJnQDzmL6FJKjJ2S9XLksPe+NqVAdDvPTMENEpORDCLN9w4UcXuPDBTSsyaQsOKGsheXKRe+oCmzEBtToLudJ+TTI6fJOAtzgopkEPwZVOt3HTEYtGsqOeUSnKy5KpSQuOXBxiIpfpc9DNztE83EMi0GsunUtaf8PY43lG4Uii9gTfB2SNnPeC6XS+Qn9gyxhIvwpo56fHWbTEGWyKz576ZZbHz0iViEmQgbmbPLYPn4sLsEyz5fvoB729QV2ihEOm9SLSnC23Hi+8ePHOlIvy1QnoDEsW42g5oBp3kdG32dos26pbJdK8tUriYhHQqyYWAvl4evkIuwSlbVv81xKRIhCZcms9DT8xKOKAYHQsRCZAN1+NiUVxPHk1QvQS83L8/NTMKT3/jwrfBpvuMSOk335rV2Gbgt7jEnxpHrLZVSvxyCwhr1PSvJbaadJvpeXL6hA66HM04j6cVvKG436/VOGWqPMUmeuEaAP87n9LIdXc5dgujEfiuDH8gdzwHgc0paQRxAQtq4rW6F/hjXRVD0WouuhiagLa4ZNaUuVlIWwellLZTBYx/ap35aoUwuXbyKqhtxH+vAy1UENQ17XBWWn349GRmNZ6z9FZ9hzuhCWOo/+fwGa3dtwQbm34aKMysvmuBmXZqZ7BlyqDK2/AUfUqCRecX0c3w41hsXfYijfY//hD7fD4/EPpb0jQYmgtNEAAAAASUVORK5CYII="
                style="margin-top: 2rem;width: 78pt; height: 40pt;" alt="image"></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p style='margin-left:36.0pt;text-indent:-36.0pt;'>
            <span>{{ $user->program->coordinator->fullname }}</span>
        </p>
        <p style='margin-left:36.0pt;text-indent:-36.0pt;'>
            <span>Coordinator of Industrial Training
                (CS251)</span>
        </p>
        <p style='text-align:justify;'><span>UiTM Cawangan Melaka Kampus Jasin</span></p>
        <p style='text-align:justify;'><span>77300 Merlimau, Melaka</span></p>
        <p><span>Office no: &nbsp;062645575</span></p>
        <p><span>E-mail:mohamad_asrol@uitm.edu.my</span></p>
    </div>
</body>

</html>
