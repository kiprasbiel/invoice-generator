<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
<div>
    <h1 class="text-align-center">
        <h4 class="super-small-margin">Sąskaita faktūra</h4>
        <p class="no-margin">Serija ir Nr. SF 123</p>
        <p class="no-margin">Sąskaitos data 2020-08-11</p>
    </h1>
</div>

<table class="full-width">
    <tr>
        <td class="half-width">
            <div><strong>Pardavėjas</strong></div>
            @if($activitySettings->full_name)
                <div>{{ $invoiceData->full_name }}</div>
            @endif
            @if($activitySettings->iv_code)
                <div>Individualios veiklos pažymos nr. {{$activitySettings->iv_code}}</div>
            @endif
            @if($activitySettings->vat)
                <div>PVM mokėtojo kodas {{$activitySettings->vat}}</div>
            @endif
            @if($activitySettings->personal_code)
                <div>Asmens kodas {{$activitySettings->personal_code}}</div>
            @endif
            @if($activitySettings->address)
                <div>{{$activitySettings->address}}</div>
            @endif
            @if($activitySettings->phone)
                <div>{{$activitySettings->phone}}</div>
            @endif
            @if($activitySettings->email)
                <div>{{$activitySettings->email}}</div>
            @endif
            @if($activitySettings->additional_info)
                <div>{{$activitySettings->additional_info}}</div>
            @endif
            @if($activitySettings->bank_name && $activitySettings->bank_account_num)
                <div>{{$activitySettings->bank_name}} — {{$activitySettings->bank_account_num}}</div>
            @endif
        </td>
        <td class="half-width vertical-align-top">
            <div><strong>Pirkėjas</strong></div>
            @if($invoiceData->company_name)
                <div>{{ $invoiceData->company_name }}</div>
            @endif
            @if($invoiceData->company_code)
                <div>Įm. kodas {{ $invoiceData->company_code }}</div>
            @endif
            @if($invoiceData->company_vat)
                <div>PVM mokėtojo kodas {{ $invoiceData->company_vat }}</div>
            @endif
            @if($invoiceData->company_address)
                <div>{{ $invoiceData->company_address }}</div>
            @endif

        </td>
    </tr>
</table>

<div class="margin-top-normal">
    <table style="border-spacing: unset; width: 100%">
        <thead>
        <tr>
            <th class="border-bottom full-width">Pavadinimas</th>
            <th class="border-bottom">Kiekis</th>
            <th class="border-bottom">Matas</th>
            <th class="border-bottom">Kaina</th>
            <th class="border-bottom">Išviso</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoiceMeta as $index => $product)
            @if($index !== 'total_invoice_price')
                <tr>
                    <td class="border-bottom full-width">{{ $product->product_name }}</td>
                    <td class="border-bottom text-align-center">{{ $product->product_pcs }}</td>
                    <td class="border-bottom text-align-center">{{ $product->pcs_type }}</td>
                    <td class="border-bottom text-align-center">{{ $product->product_price }} &euro;</td>
                    <td class="border-bottom text-align-center">{{ $product->total_price }} &euro;</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

<div class="text-align-right">
    <div><strong>Bendra suma</strong> {{$invoiceMeta->total_invoice_price}} &euro;</div>
</div>

<div class="margin-top-normal">
    Suma žodžiais : Du šimtai dvidešimt devyni Eur ir 0 ct
</div>
<div class="margin-top-normal">
    Sąskaitą išrašė: Kipras Bielinskas
</div>

</body>
</html>
