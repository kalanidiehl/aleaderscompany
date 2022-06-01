<?php

function rules_createcalendarinvite_rules_action_info() {
  return [
    'create_invite' => [
      'label' => t('Create Calendar Invite'),
      'group' => t('Custom'),
      'parameter' => [
        'meeting_node' => [
          'type' => 'node',
          'label' => t('Meeting Node'),
          'description' => t('Choose the node to create the meeting invite email from'),
        ],
      ],
      'module' => 'rules_createcalendarinvite',
      'callbacks' => ['execute' => '_rules_createcalendarinvite_create_invite'],
    ],
  ];
}

function _rules_createcalendarinvite_create_invite($meeting_node) {
  date_default_timezone_set('UTC');

  $ics_path = $meeting_node->nid;
  $organizer = user_load($meeting_node->uid);
  $from_name = $organizer->field_address['und'][0]['name_line'];
  $from_email = $organizer->mail;

  $invitee = user_load($meeting_node->field_invitee['und'][0]['value']);
  $to_name = $invitee->field_address['und'][0]['name_line'];;
  $to_email = $invitee->mail;


  $UID = md5(strval($meeting_node->nid) . strval($meeting_node->name));

  $ical = "BEGIN:VCALENDAR\n" .
    "PRODID:-//Google Inc//Google Calendar 70.9054//EN\n" .
    "VERSION:2.0\n" .
    "CALSCALE:GREGORIAN\n" .
    "METHOD:REQUEST\n" .
    "BEGIN:VEVENT\n" .
    "DTSTART:" . _rules_createinvite_dateToCal($meeting_node->field_scheduled_time['und'][0]['value']) . "\n" .
    "DTEND:" . _rules_createinvite_dateToCal($meeting_node->field_scheduled_time['und'][0]['value2']) . "\n" .
    "DTSTAMP:" . _rules_createinvite_dateToCal(time()) . "\n" .
    "ORGANIZER;CN=" . $from_name . ":mailto:" . $from_email . "\n" .
    "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE;CN=" . $from_name . ";X-NUM-GUESTS=0:mailto:" . $from_email . "\n" .
    "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=" . $to_name . ";X-NUM-GUESTS=0:mailto:" . $to_email . "\n" .
    "UID:$UID\n" .
    "DESCRIPTION:" . $meeting_node->body['und'][0]['value'] . "\n" .
    "LAST-MODIFIED:" . _rules_createinvite_dateToCal(time()) . "\n" .
    "LOCATION:a location\n" .
    "SEQUENCE:0\n" .
    "STATUS:CONFIRMED\n" .
    "SUMMARY:" . $meeting_node->title . "\n" .
    "TRANSP:OPAQUE\n" .
    "END:VEVENT\n" .
    "END:VCALENDAR\n";


  //build the email
  $my_module = 'rule_createcalendarinvite';
  $my_mail_token = microtime();

  $message = [
    'id' => $my_module,
    'from' => $organizer->mail,
    'to' => $to_email,
    'subject' => $meeting_node->title,
    'body' => $ical,
    'headers' => [
      'From' => $organizer->mail,
      'Sender' => $organizer->mail,
      'Return-Path' => $organizer->mail,
      'Content-Type' => 'text/calendar; charset="UTF-8"; method=REQUEST' . "\n",
      'Content-Disposition' => 'inline; filename=calendar.ics',
      'Content-Transfer-Encoding' => '7bit' . "\n\n",
    ],
  ];

  $system = drupal_mail_system($my_module, $my_mail_token);
  if ($system->mail($message)) {

    return TRUE;
  }
  else {
    return FALSE;
  }


}

function _rules_createinvite_dateToCal($time) {
  date_default_timezone_set('UTC');
  $date = date('Ymd\THis', $time) . 'Z';
  return $date;
  //return date('Ymd\This', $time);
}

