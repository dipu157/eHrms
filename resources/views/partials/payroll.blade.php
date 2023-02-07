<span class="heading" style="font-weight: bold; color: #980000">PAYROLL</span>
<li><a class="font-weight-bold" href="#salaryDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-grid"></i>SALARY & BONUS</a>
    <ul id="salaryDropdown" class="collapse list-unstyled ">
        <li><a href="{!! route('payroll/salarySetupIndex') !!}">Salary Setup</a></li>
        <li><a href="{!! route('payroll/salaryProcessIndex') !!}">Salar&Bonus Process</a></li>
        <li><a href="{!! route('payroll/salaryUpdateIndex') !!}">Salary Update</a></li>
        <li><a href="{!! route('payroll/prevSalaryIndex') !!}">Previous Month's Salary</a></li>
        <li><a href="#saleryReportDropdown" aria-expanded="false" data-toggle="collapse">Salary Report</a></li>
        <ul id="saleryReportDropdown" class="collapse list-unstyled " style="padding-left: 20px">
            <li><a href="{!! route('payroll/salaryReportIndex') !!}">Salary Statement</a></li>
            <li><a href="{!! route('payroll/CashsalaryReportIndex') !!}">Cash Salary</a></li>
            <li><a href="{!! route('payroll/bankLetterIndex') !!}">Letter to Bank</a></li>
            <li><a href="{!! route('payroll/overtimeReportIndex') !!}">Overtime Report</a></li>
            <li><a href="{!! route('payroll/heldupIndex') !!}">Heldup List</a></li>
        </ul>

        <li><a href="#bonusReportDropdown" aria-expanded="false" data-toggle="collapse">Bonus Report</a></li>
        <ul id="bonusReportDropdown" class="collapse list-unstyled " style="padding-left: 20px">
            <li><a href="{!! route('payroll/bonusReportIndex') !!}">Bonus Statement</a></li>
            <li><a href="{!! route('payroll/bonusTobankIndex') !!}">Bonus to Bank</a></li>
            <li><a href="{!! route('payroll/cashbonusIndex') !!}">Cash Bonus</a></li>
        </ul>

    </ul>

</li>


<li><a class="font-weight-bold" href="#incrementDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-grid"></i>INCREMENT</a>
    <ul id="incrementDropdown" class="collapse list-unstyled ">
        <li><a href="{!! route('payroll/incrementSetupIndex') !!}">Increment Setup</a></li>
        <li><a href="#incrementReportDropdown" aria-expanded="false" data-toggle="collapse">Report</a></li>
        <ul id="incrementReportDropdown" class="collapse list-unstyled " style="padding-left: 20px">
            {{--<li><a href="{!! route('payroll/salaryReportIndex') !!}">Increment Report </a></li>--}}
        </ul>
    </ul>
</li>

<li><a class="font-weight-bold" href="#arearDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-grid"></i>AREAR</a>
    <ul id="arearDropdown" class="collapse list-unstyled ">
        <li><a href="{!! route('payroll/arearSetupIndex') !!}">Arear Setup</a></li>
        <li><a href="#arearReportDropdown" aria-expanded="false" data-toggle="collapse">Report</a></li>
        <ul id="arearReportDropdown" class="collapse list-unstyled " style="padding-left: 20px">
            {{--<li><a href="{!! route('payroll/salaryReportIndex') !!}">Monthly Salary Report </a></li>--}}
        </ul>
    </ul>
</li>
