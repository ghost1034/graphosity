@extends('layouts.app')
@section('content')
    <div id="interface">
        <div id="keypad-area">
            <form id="keypad-form">
                @csrf
                <input type="hidden" name="equation-type" id="equation-type" value="">
                <table class="keypad">
                    <tr>
                        <td colspan="4"><input type="text" name="keypad-input" id="keypad-input"></td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="keypad-button">1</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">2</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">3</button>
                        </td>
                        <td rowspan="4">
                            <table class="keypad" id="symbols"></table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="keypad-button">4</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">5</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">6</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="keypad-button">7</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">8</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">9</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="keypad-button">.</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">0</button>
                        </td>
                        <td>
                            <button type="button" class="keypad-button">C</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="graph-area">
            <canvas id="graph" class="grabbable">Your browser does not support the HTML canvas tag.</canvas>
        </div>
        <div id="result-area">
          <textarea id="result" disabled></textarea>
        </div>
    </div>
@endsection
