<style>
    table.border, table.border th, table.border td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<table width="100%">
    <tbody>
    <tr>
        <td width="50%" valign="top">
            <span style="font-size: 12px; font-style: italic;">
                Export period: {!! $from !!} - {!! $to ?? '' !!}<br>
                Created at: {!! now()->toDateTimeString() !!}
            </span>
        </td>
        <td width="50%">
            <table class="border" width="100%">
                <thead>
                <tr>
                    <th width="60%">Project</th>
                    <th width="40%">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($totals as $total)
                    <tr>
                        <td>{!! $total->name !!}</td>
                        <td align="right">{!! gmdate('H:i:s',$total->duration ?? 0) !!}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<br>
<table width="100%" class="border">
    <thead>
    <th>Project</th>
    <th>Start</th>
    <th >Finish</th>
    <th>Duration</th>
    <th>Rem</th>
    </thead>
    <tbody>
    @foreach($timeTrackings as $tracking)
        <tr>
            <td width="200px">{!! $tracking->project->name !!}</td>
            <td width="100px">{!! $tracking->start_at->toDateTimeString() !!}</td>
            <td width="100px">{!! $tracking->end_at->toDateTimeString() !!}</td>
            <td width="100px" align="right">{!! gmdate('H:i:s',$tracking->duration_in_seconds ?? 0) !!}</td>
            <td width="200px">{!! $tracking->rem !!}</td>
        </tr>
    @endforeach

    </tbody>
</table>
