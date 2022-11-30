@extends('layouts.layout')
@section('title', 'Showing Now')

<?php $activeLink = "contact"; ?>

@section('content')
<h2>Contact Us</h2>
<h5>Any doubt, comment or share your experience</h5>

<form>
    <table>
        <tbody>
            <tr>
                <td><label for="fname">First Name*</label></td>
                <td>
                    <input
                        type="text"
                        id="fname"
                        name="firstname"
                        placeholder="Your name"
                        required
                    />
                </td>
            </tr>

            <tr>
                <td><label for="mail">E-Mail*</label></td>
                <td>
                    <input
                        type="email"
                        id="mail"
                        name="custEmail"
                        placeholder="Your email"
                        required
                    />
                </td>
            </tr>

            <tr>
                <td><label for="phone">Phone number</label></td>
                <td>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="(nnn) nnn-nnnn"
                        pattern="^\d{10}$|^(\(\d{3}\)\s*)?\d{3}[\s-]?\d{4}$"
                    />
                </td>
            </tr>

            <tr>
                <td><label for="reason">Subject</label></td>
                <td>
                    <select name="reasonType" id="reason">
                        <option value="reason1">Nice page</option>
                        <option value="reason2">Add more features</option>
                        <option value="reason3">Networking</option>
                        <option value="reason4">Design improvement</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label for="reason">Comment</label></td>
                <td>
                    <textarea
                        id="comment"
                        name="comment"
                        placeholder="Elaborate your message please"
                        style="height: 200px"
                    ></textarea>
                </td>
            </tr>
        </tbody>
    </table>

    <input type="reset" value="Reset Form" />
    <input type="submit" value="Send" />
</form>
@endsection