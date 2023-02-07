<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    


    <style>
        table.table {
            width:100%;
            margin:0;
            background-color: #ffffff;
        }

        table.order-bank {
            width:100%;
            margin:0;
        }
        table.order-bank th{
            padding:5px;
        }
        table.order-bank td {
            padding:5px;
            background-color: #ffffff;
        }
        tr.row-line th {
            border-bottom-width:1px;
            border-top-width:1px;
            border-right-width:1px;
            border-left-width:1px;
        }
        tr.row-line td {
            border-bottom:none;
            border-bottom-width:1px;
            font-size:10pt;
        }
        th.first-cell {
            text-align:left;
            border:1px solid red;
            color:blue;
        }
        div.order-field {
            width:100%;
            backgroundr: #ffdab9;
            border-bottom:1px dashed black;
            color:black;
        }
        div.blank-space {
            width:100%;
            height: 50%;
            margin-bottom: 100px;
            line-height: 10%;
        }

        div.blank-hspace {
            width:100%;
            height: 25%;
            margin-bottom: 50px;
            line-height: 10%;
        }
    </style>

</head>
<body>
<div class="blank-space"></div>

<table border="0" cellpadding="0">

    <tr>
        <td width="33%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:250px;height:60px;"></td>
        <td width="2%"></td>
        <td width="60%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br/> West Panthapath, Dhaka-1215</span></td>

    </tr>
    <hr style="height: 2px">

</table>

<div class="blank-space"></div>

    @if(!empty($data))

        <div>
            <table style="width: 100%">
                <tr><td></td></tr>
                <tr>
                    <td>BHL <br/>
                    Date: </td></tr> <br>

                <tr><td>{{ $data[0]->name }} <br/>
                D/O {{ $data[0]->fathers_name }} <br/>
                {{ $data[0]->present_address }}</td></tr> <br/>

                <tr><td style="text-align: center; font-size: 14px; font-weight: bold;"> Sub: Letter of Appointment </td></tr> <br> <br>
                <tr><td>Dear {{ $data[0]->name }}, <br/><br/>
                    With reference to your application and subsequent interview with us on {{ $data[0]->submission_date }} and decision taken on {{ $data[0]->submission_date }}, we are pleased to offer you the position of <strong> "{{ $data[0]->designation->name }}"</strong> under the following terms and conditions: <br/>

                    <p style="font-weight: bold;">1.0   Appointment: </p> <br/><br/>

                    1.1 Your services will be governed by the rules & regulations of the company as in force from time to time, Including any amendment or modifications thereof. <br/>

                    1.2 You are appointed as <strong>"{{ $data[0]->designation->name }}"</strong> in <strong>Grade – {{ $data[0]->salary_grade }}"</strong> in the department of {{ $data[0]->department->name }} of the company on full time basis.<br/><br/>

                    1.3     You will be on probation for a period of {{ $data[0]->provision_period }} months from the date of your joining. During the probation period, your employment may be terminated without notice and without assigning any reasons. It may be extended further for a period of three months, if your performance is found not satisfactory. After successful completion of your probation period your employment will be confirmed. <br/><br/>

                    1.4 Primarily your work location will be at BRB Hospitals Limited, 77/A, East Rajabazar, West Panthapath, Dhaka. <br/><br/>

                    1.5   Your working time will be fixed as decided by the company authority and you will acknowledge and agree that the   nature of your work may require long working hours than the normal to complete your assigned responsibilities. <br/>

                    <p style="font-weight: bold;">2.0   Salary and Benefits:</p> <br/><br/>

                    2.1 During the probation period, you will be entitled to get a consolidated salary of <strong> Tk. {{ $data[0]->provision_salary }}/= ({{ convert_number_to_words($data[0]->provision_salary) }}) </strong> only per month. After confirmation, your salary will be structured complying with the rules and regulations of the Company. In addition to your monthly salary, you will be entitled for benefits according to the prevailing policies of the Company. <br/><br/>

                    2.2 You will be liable to pay the income tax in accordance with the prevailing income tax rules & regulations of the country and will be deducted at source. <br/>

                    <p style="font-weight: bold;">3.0 Duties, Responsibilities & Code of conduct:</p> <br/><br/>

                    3.1 You will work under the direct supervision of the Managing Authority or Authorized representative as decided by the Board of Directors. <br/><br/>

                    3.2     The company is an independent organization and is being managed and organized by professionals/experts, you shall abide by the rules and regulations set by the company authority. Any behavior with the staff and member of the management of the hospital, which is considered against the etiquette, norms and ethics of the organization, will be treated as gross violation to the terms and conditions of this appointment. <br/><br/>

                    3.3 During the period of your service, you will extend your best effort in promoting and safeguarding the interest of the company and diligently and to the best of your ability, devote yourself for the duties and responsibilities assigned to you and shall faithfully observe and comply with such instruction as you may receive time to time from the company or their authorized representatives. <br/><br/>

                    3.4   Your service may be transferred to any other places or concern of BRB Group as required under the discretion of the management.   <br/>

                    3.5   You shall not directly or indirectly engage yourself in any other profession, either part time or full time during your service with us without prior written consent from the management.
<br/><br/>
                    3.6 You will be responsible for the charge and care of the company’s money, goods and property as and when entrusted to you / in your hands and will truly and faithfully account for everything. You will be entitled to use those properties in the interest of the company. You will also be entitled to handover or deliver to the same to any authorized person under your charge. In the event, if you are established or proven or found guilty as responsible for any losses of company’s money / materials / properties, while discharging your duties during in current position or at previous positions, the management will recover such money / materials / properties or equivalent at the sole discretion of the management by all means. <br/><br/>

                    3.7 You will not create any untoward circumstances or involve with any immoral and illegal activities which can damage the reputation of the company. <br/>

                   <p style="font-weight: bold;"> 4.0   Termination :</p> <br/><br/>
                    
                    4.1 You are not allowed to resign from the appointed position suddenly. In the case of any unavoidable circumstances, you may resign from the service by giving two (02) months prior notice in writing or surrendering two month salary in lieu thereof subject to proper and acceptable handover of your duties and responsibilities. If you submit your resignation letter in absenting period without proper handover the responsibilities or absent and establish such manner in which company authority reserves the right to dismiss you from the service & your dues will be forfeited.  <br/><br/>
                    
                    4.2     In case, you act in the manner, which amounts to an action equivalent to gross misconduct, willingly suppressed any information during interview, false declaration, discrepancy in certificates / documents, negligence of duties, unprofessional, unethical or unreasonable behavior, your service will be discontinued forthwith in addition administrative action will be taken against you and no compensation will be paid. <br/>
                    
                    <p style="font-weight: bold;">5.0 Secrecy: </p> <br/><br/>

                    You will strictly maintain secrecy and confidentiality of your assigned job and arrange preventing divulgence of any secret information, documents, instruments and all affairs of company’s activities and its customers (herein after collectively referred to as information) during tenure of your service with us or thereafter and shall not at any time in any way use such information to the detriment directly or indirectly of the company or its customers. You shall incur personal liability in case of breach of this obligation. <br/>
                    
                   <p style="font-weight: bold;"> 6.0 Amendment and Change to this appointment letter: </p><br/> <br/>
    
                    The Authority reserves the right to amend, add or delete any of the above mentioned terms and conditions whole or part thereof. <br/> <br/>

                    If the above terms & conditions are acceptable to you, please return the duplicate copy of this letter duly signed by you as token of your acceptance and you will have to join at BRB Hospitals Ltd ( 77/A, East Rajabazar, West Panthapath, Dhaka-1215) on or before <strong>{{ $data[0]->joining_date }} </strong>with all academic, experience, training, registration  certificates (if applicable), 3 copies PP and 2 copies stamp size photograph, NID/nationality certificate failing which this offer will be treated as cancelled. <br/>
                    Thank you and wish you a successful career with us. <br/>
                </td>
            </tr>

            <tr>
                <td style="width: 70%"></td>
                <td style="width: 30%">For BRB Hospitals Limited</td>
            </tr><br/><br/>

            <tr>
                <td style="width: 80%"></td>
                <td style="width: 20%">Chief Executive Officer</td>
            </tr><br/><br/>

            <tr>
                <td style="width: 80%">
                  <strong> Copy to: </strong><br/><br/>
    01. Managing Director, BRB Hospitals. Ltd. <br/>
    02. Finance & Accounts Dept. 03. Personal File, 04.Office Copy / Master File

                </td>
            </tr> <br/><br/>

            <tr>
                <td style="width: 80%"></td>
                <td style="width: 20%">Chief Executive Officer</td>
            </tr>
            </table>
        </div>

    @endif

<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

