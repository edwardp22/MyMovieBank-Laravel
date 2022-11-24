@extends('layouts.layout')
@section('title', 'Showing Now')

<?php $activeLink = "contact"; ?>

@section('content')
<h2>Contact Us</h2>
<h5>Any doubt, comment or share your experience</h5>

<form action="send-mail.php">
    <label for="fname">First Name*</label>
    <input
    type="text"
    id="fname"
    name="firstname"
    placeholder="Your name"
    required
    />

    <label for="mail">E-Mail*</label>
    <input
    type="email"
    id="mail"
    name="custEmail"
    placeholder="Your email"
    required
    />

    <label for="phone">Phone number</label>
    <input
    type="tel"
    id="phone"
    name="phone"
    placeholder="(nnn) nnn-nnnn"
    pattern="^\d{10}$|^(\(\d{3}\)\s*)?\d{3}[\s-]?\d{4}$"
    />

    <label for="reason">Subject</label>
    <select name="reasonType" id="reason">
    <option value="reason1">Nice page</option>
    <option value="reason2">Add more features</option>
    <option value="reason3">Networking</option>
    <option value="reason4">Design improvement</option>
    </select>

    <label for="reason">Comment</label>
    <textarea
    id="comment"
    name="comment"
    placeholder="Elaborate your message please"
    style="height: 200px"
    ></textarea>

    <input type="reset" value="Cancel" />
    <input type="submit" value="Submit" />
</form>
@endsection