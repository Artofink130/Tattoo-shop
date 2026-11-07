@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ config('studio.logo_url') ?: asset('img/logo.png') }}" alt="{{ config('app.name') }}" width="90" height="90" style="width:90px;height:90px;max-width:100%;">
</a>
<div style="font-size:18px;font-weight:bold;letter-spacing:2px;color:#d04b4b;margin-top:6px;">{{ strtoupper(config('app.name')) }}</div>
</td>
</tr>
