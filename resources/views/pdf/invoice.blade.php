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
            <div>Kipras Bielinskas</div>
            <div>Individualios veiklos pažymos nr. 761707</div>
            <div>Asmens kodas: 39808240516</div>
            <div>Nemuno krantinė 26-6, Kaunas, LT-45273, Lietuva</div>
            <div>+37064141272</div>
            <div>info@anaweb.lt</div>
            <div>www.anaweb.lt</div>
            <div>Swedbank — LT117300010139945347</div>
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
    <table style="border-spacing: unset">
        <thead>
        <tr>
            <th class="border-bottom">Pavadinimas</th>
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
                    <td class="border-bottom">{{ $product->product_name }}</td>
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
