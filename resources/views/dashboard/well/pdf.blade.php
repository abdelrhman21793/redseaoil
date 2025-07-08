<!DOCTYPE html>
<html>

<head>
    <title>Red Sea Oil</title>
    <link rel="stylesheet" href="{{ asset('build/assets/wellPDF.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @foreach ($options as $option)
        <div class="option">
            <div class="card">
                <div class="card head" style="border: 1px solid">
                    <div class="row g-0">
                        <div class="col-md-4 ">
                            <img src={{ asset('storage/Capture.PNG') }} class="icon img-fluid  p-2">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3><b>{{ $well->name }}</b></h1>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4><b>From: {{ $well->from }}</b>
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <h4><b>To: {{ $well->to }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Well: {{ $well->well }}</h3>
                            </div>
                            <div class="col-md-6">
                                <h4>Rig: {{ $well->rig }}</h3>
                            </div>
                        </div>
                        <h4>Gauge Installed/Pulled By:{{ $well->user->name }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="structure_description">
            @foreach ($option->structures as $structure)
                <h3 class="structureName text-center mb-0 mt-2"><b>{{ $structure->name }}</b></h3>
                <div class="grid">
                    @foreach ($structure->structure_descriptions as $struct_desc)
                        @if (
                            $struct_desc->type == 'String' ||
                                $struct_desc->type == 'Int' ||
                                $struct_desc->type == 'User' ||
                                $struct_desc->type == 'Boolean' ||
                                $struct_desc->type == 'Date' ||
                                $struct_desc->type == 'List' ||
                                $struct_desc->type == 'date_desc')
                            <div class="tableRows">
                                <span style="text-align: left;"><b>{{ $struct_desc->input }}:</b></span>
                                @php
                                    $found = false;
                                @endphp
                                @foreach ($structureDescriptions as $strc_desc)
                                    @if ($strc_desc->id == $struct_desc->id)
                                        @php
                                            $found = true;
                                            $data = $strc_desc->pivot->data;
                                            $decodedData = json_decode($data, true);
                                            if (is_array($decodedData)) {
                                                $numericValues = array_filter($decodedData, 'is_numeric');
                                                $formattedData = implode(' ', $numericValues);
                                            } else {
                                                $formattedData = stripslashes($data); // Remove slashes
                                                $formattedData = str_replace('"', '', $formattedData); // Remove double quotes
                                            }
                                        @endphp
                                        <span style="text-align: left;"><b>{{ $formattedData }}</b></span>
                                    @break
                                @endif
                            @endforeach
                            @if (!$found)
                                <span style="text-align: left;"><b></b></span>
                            @endif
                        </div>
                    @endif
                @endforeach

                @php
                    $multiTextInputs = [];
                @endphp

                @foreach ($structure->structure_descriptions as $struct_desc)
                    @if ($struct_desc->type == 'MultiText')
                        @php
                            $multiTextInputs[] = $struct_desc;
                        @endphp
                    @endif
                @endforeach

                @if (!empty($multiTextInputs))
                    <div>
                        <table style="border: 1px solid;width:794px">
                            <thead style="border: 1px solid;">
                                <tr style="border: 1px solid;">
                                    <th style="border: 1px solid;"></th>
                                    <th style="border: 1px solid;">Pi</th>
                                    <th style="border: 1px solid;">Pd</th>
                                    <th style="border: 1px solid;">Ti</th>
                                    <th style="border: 1px solid;">Tm</th>
                                    <th style="border: 1px solid;">Ct</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($multiTextInputs as $multiText)
                                    <tr>
                                        <td style="border: 1px solid;">{{ $multiText->input }}</td>
                                        @foreach ($structureDescriptions as $strc_desc)
                                            @if ($strc_desc->id == $multiText->id)
                                                @php
                                                    // Remove double quotes at the beginning and end of the string
                                                    $dataString = trim($strc_desc->pivot->data, '"');

                                                    // Remove any backslashes
                                                    $dataString = stripslashes($dataString);

                                                    // Decode the JSON string
                                                    $decoded_data = json_decode($dataString, true);
                                                @endphp
                                                @if ($decoded_data)
                                                    @foreach ($decoded_data as $key => $value)
                                                        <td style="border: 1px solid;">
                                                            @if ($value !== null)
                                                                {{ $value }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    </div>
    </div>
@endforeach
</body>

</html>
