<?php require_once ('titletop.php');
require_once ('navheaderside.php'); ?>
<div class="Content">
<span style="font-weight: bold;"><span style="font-weight: bold;"><span
 style="font-weight: bold;">FAQ:<br>
<a href="#whomade">Who made this?</a><br>
<a href="#feedback">Can I provide feedback?</a><br>
<a href="#contact">How can I contact you?</a><br>
<a href="#register">Do I need to register or log in to use ELDER?</a></span><br>
<br>
How-to: How do I...<br>
<a href="#gloss">Gloss a sentence?</a><br>
<a href="#tones">Add tones for a sentence?</a><br>
<a href="#vowels">Standardize my vowels?</a><br>
<a href="#consonants">Standardize my consonants?</a><br>
<a href="#syltype">Format "syllable type"?</a><br>
<a href="#audio"><span style="font-weight: bold;">Encode my audio files?</span></a><br>
<a href="#metadata">Add metadata to my audio files?</a><br>
<a href="#naming">Name my audio files?</a><br>
<br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="whomade"></a>Who made this?<br>
<br>
</span></span></span>ELDER was designed by Anna Belew for her master's
thesis in the Boston University Program for Applied Linguistics.&nbsp;
It was programmed pro bono by Connor Shaughnessy using Notepad++ and
MySQL.&nbsp; ELDER is based
on a FileMaker layout by Cathy O'Connor and Amy Rose Deal.&nbsp; <br>
<span style="font-weight: bold;"><span style="font-weight: bold;"><br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="feedback"></a>Can I
provide feedback?<br>
<br>
</span></span></span>ELDER's improvement depends on you and your
feedback!&nbsp; If you discover bugs, notice faulty design, or have
ideas for features you'd like to see, please <a
 href="mailto:anna.belew@gmail.com">
let us know!</a><br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="contact"></a>How can I
contact you?<br>
<br>
<span style="font-weight: bold;"></span></span>I'm happy to help out
with any questions or problems.&nbsp; Email me at
<a href="mailto:anna.belew@gmail.com">anna.belew@gmail.com</a> <span
 style="font-weight: bold;"><span style="font-weight: bold;"></span><br>
</span><br>
<span style="font-weight: bold;"><span style="font-weight: bold;"><span
 style="font-weight: bold;"></span><br>
<br>
<br>
<br>
<a name="register"></a>Do I need to register or log in to use ELDER?<br></span></span>
<br>
Short answer: No. However, to preserve
the hard work of its users, ELDER does not allow casual modification or deletion of data by anyone other than the person who entered it.
So, if you've contributed something but need to change or get rid of it, you must <a href="/register.php">register</a> and/or <a href="/login.php">log in</a>.
  If you haven't entered any data yet, your name won't appear on the registration screen, but nor do you have any need to register!  Anyone can look around or create new entries
  without logging in.<br>
<br>
<br>
<br>
<br>
<br>
<big><big><span style="font-weight: bold;">How do I....</span></big></big><br>
<br>
<br>
<a name="gloss"></a>Gloss a sentence?<br>
<br>
</span></span>The <span style="text-decoration: underline;">free
translation</span> is simply a rough translation into English; for
example, the free translation of /m&#601; j&#601;n busi gi/ would be "Did I see
the cat?" rather than "I saw cat question."&nbsp; It's meant to convey
the general meaning of an utterance rather than the details.<br>
<br>
The <span style="text-decoration: underline;">close gloss</span> is a
more detailed representation of the sentence.&nbsp; The <span
 style="text-decoration: underline;">close gloss</span> should
represent not only an English translation of the word, but any details
about case, number, tense, etc. for a given word.&nbsp; The database
reads spaces in the gloss line as meaning word breaks, so don't put
spaces in the gloss for a single word; use hyphens if you need to gloss
something as more than one word.&nbsp; For example, /m&#601; j&#601;n kwit&#643;&#623; gi/
would have a close gloss something like this:<br>
<br>
m&#601;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
j&#601;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
kwit&#643;&#623;
&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
gi<br>
1p-sg-nom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
see-pst1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
tree-parasite &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; question marker<br>
<br>
And would be entered into the close gloss box as:<br>
<br>
1p-sg-nom see-pst1 tree-parasite question-marker<br>
<br>
<span style="font-weight: bold;">If you're not sure exactly what
something is</span>, leave it blank rather than guessing.&nbsp; Just
<span style="font-weight: bold;">put a question mark in place of a gloss</span>,
using the same
spaces-between-words convention.&nbsp; ELDER will then show a blank
space for that word in the close gloss.&nbsp; For example:<br>
<br>
t&#643;a&#331;mvun&#658;u mi k&#596; arian n&#603;n&#593; &nbsp;&nbsp;&nbsp;&nbsp; <br>
evening-meal ? then Ariane go-pst1<br>
<br>
For the sake of consistency, please see the tense table and
noun/pronoun table so that we're all using the same standardized
abbreviations.<br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-weight: bold;"><br>
<br>
<br>
<a name="tones"></a>Add tones for a sentence?<br>
</span></span><br>
Keep in mind that the <span style="text-decoration: underline;">analyzed
tone</span> and <span style="text-decoration: underline;">sentence-level
pitch</span> are different things.&nbsp; <span
 style="text-decoration: underline;">Analyzed tone</span> would be your
phonological breakdown of the pitch into H and L tones.&nbsp; If you
haven't taken phonology, don't worry about this part; just record the
sentence-level pitch as best you can.<br>
<br>
The syntax for inputting <span style="text-decoration: underline;">sentence-level
pitch</span> is pretty simple: insert
a semicolon to represent word breaks, and a comma to represent syllable
breaks.&nbsp; So if we have the following sentence:<br>
<br>
&nbsp; 3&nbsp;&nbsp;&nbsp;&nbsp; 5&nbsp;&nbsp;&nbsp;&nbsp;
2&#865;3&nbsp;&nbsp;&nbsp;&nbsp; 2 1<br>
m&#603;nzwi sw&#603;n kolo<br>
<br>
We'd input the tone as 3,5;23;2,1 in the text box.<span
 style="font-weight: bold;">&nbsp; </span><span
 style="font-weight: bold;"></span>We know that the average linguist
doesn't want to deal with complex syntax when using a tool (unless you
love using LaTeX).&nbsp; Someday we'll have a more
intuitive input system-- stay tuned.<span style="font-weight: bold;"></span><span
 style="font-weight: bold;"><br>
<br>
<span style="font-weight: bold;"></span></span>To add <span
 style="text-decoration: underline;">analyzed tone</span> for a sentence<span
 style="font-weight: bold;"></span>, don't worry about syntax; we
haven't decided on a good way to feed underlying tones to the database
yet.&nbsp; Just input any string of text, using standard phonological
markup for downstep (e.g. !H or &#8595;H)<br>
<span style="font-weight: bold;"></span><span style="font-weight: bold;"><br>
<br>
<br>
<span style="font-weight: bold;"><a name="vowels"></a>Standardize my
vowels?<br>
<br>
<span style="font-weight: bold;"></span></span></span>At the moment,
we've agreed to use the following vowel inventory:<br>
<br>
<span style="font-weight: bold;"><span style="font-weight: bold;"><span
 style="font-weight: bold;"></span></span></span>
<table style="text-align: left; width: 256px; height: 167px;" border="0"
 cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align: top;">i<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><big><big><big>&#623;</big></big></big>&nbsp;
u<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">&#601;<br>
      </td>
      <td style="vertical-align: top;">o<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;">&#603;<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">&#596;<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><big><big><big>&#592;</big></big></big><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;">a<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
  </tbody>
</table>
<span style="font-weight: bold;"><span style="font-weight: bold;"> <br>
</span></span>If you disagree, think we should add, remove, or change a
vowel, or have questions about the vowel inventory, <a
 href="mailto:anna.belew@gmail.com">contact me</a>.<br>
<span style="font-weight: bold;"><br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="consonants"></a>Standardize
my consonants?<br>
<br>
</span></span>I've been using the following consonant inventory to
represent Medumba:<br>
<br>
<table style="text-align: left;" border="1" cellpadding="2"
 cellspacing="2">
  <tbody>
    <tr>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top; text-align: left;"><small>Bilabial<br>
      </small></td>
      <td style="vertical-align: top;"><small>Labiodental<br>
      </small></td>
      <td style="vertical-align: top;"><small>Dental<br>
      </small></td>
      <td style="vertical-align: top;"><small>Alveolar<br>
      </small></td>
      <td style="vertical-align: top;"><small>Postalveolar<br>
      </small></td>
      <td style="vertical-align: top;"><small>Retroflex<br>
      </small></td>
      <td style="vertical-align: top;"><small>Palatal<br>
      </small></td>
      <td style="vertical-align: top;"><small>Velar<br>
      </small></td>
      <td style="vertical-align: top;"><small>Uvular<br>
      </small></td>
      <td style="vertical-align: top;"><small>Pharyngeal<br>
      </small></td>
      <td style="vertical-align: top;"><small>Glottal<br>
      </small></td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Stop<br>
      </small></td>
      <td style="vertical-align: top;">p&nbsp; b<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">t&nbsp;&nbsp;&nbsp; d<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">k&nbsp;&nbsp; g<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">&#660;<br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Nasal<br>
      </small></td>
      <td style="vertical-align: top;">m<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">n<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">&#331;<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Trill<br>
      </small></td>
      <td style="vertical-align: top;">&#665;<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Tap or Flap<br>
      </small></td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Fricative<br>
      </small></td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">f&nbsp;&nbsp;&nbsp; v<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">s&nbsp;&nbsp; z<br>
      </td>
      <td style="vertical-align: top;">&#643;&nbsp;&nbsp; &#658;<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">x&nbsp;&nbsp; &#611;<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Lateral fricative<br>
      </small></td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Approximant<br>
      </small></td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">j<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><small>Lateral approximant<br>
      </small></td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;">l<br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
      <td style="vertical-align: top;"><br>
      </td>
    </tr>
  </tbody>
</table>
<br>
And, of course, [w].&nbsp; <br>
<br>
Other important things:<span style="font-weight: bold;"> enter
affricates as two separate characters</span>.&nbsp; Use t&#643;u, not
&#679;u.&nbsp; This will help make everyone's entries consistent.<br>
<br>
<span style="font-weight: bold;">Don't use diacritics as part of the
main IPA entry for words or sentences</span>; put them in the "spoken
form."&nbsp; We've found no evidence that Medumba has phonemic
nasalization, dentalization, etc., and diacritics make it harder to
search accurately.<br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-weight: bold;"></span><br>
<br>
<br>
<span style="font-weight: bold;"><a name="syltype"></a>Format "syllable
type"</span>?<br>
<br>
</span>"Syllable type" is pretty basic at the moment-- the only segment
types it's concerned with are nasals (N), consonants (C) and vowels
(V).&nbsp; Don't go all super-phonologist and start inputting /mv&#603;l/ as
Nasal Fricative Vowel Liquid.&nbsp; Just stick with N, C, and V.<br>
<span style="font-weight: bold;"><br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="audio"></a>Encode my audio
files?<br>
<br>
</span></span>Short answer: make them as high-quality as
possible.&nbsp; Work with, at minimum, a sampling rate of 44.1 kHz and
bit-depth of 16.&nbsp; I don't know a ton about audio encoding, so
consider this section "under construction" until I do.&nbsp; Until
then, see <a href="http://emeld.org/school/classroom/audio/index.html">what
E-MELD
has
to
say
about
it</a>.<br>
<span style="font-weight: bold;"><span style="font-weight: bold;"></span><br>
<br>
<br>
<br>
<br>
<span style="font-weight: bold;"><a name="metadata"></a>Add metadata to
my audio files?</span></span><span style="font-weight: bold;"><br>
<br>
</span>Metadata is "data about data"-- in the case of language
documentation audio files, it helps keep track of who was involved in a
session, when it was, and what was discussed in the session.<br>
<br>
To add metadata to an mp3 file, it's easiest to use your usual media
player-- iTunes and Windows Media Player both allow users to create and
edit mp3 metadata.&nbsp; Simply use your media player to open the file
you want to tag,
right-click it, and select "get info" (or something similar).&nbsp; It
will bring up a window that should have an "Info" tab, complete with a
box for comments.&nbsp; All your metadata goes in that box.&nbsp; <br>
<br>
To add metadata to a WAV file, you're looking at a lot more work-- WAV
files don't actually support metadata embedding.&nbsp; You'll need to
find a metadata editor that adds a chunk of data in a different
format.&nbsp; I recommend just uploading MP3s to ELDER for now.<br>
<br>
What you should include in your metadata:<br>
<br>
Take a look at <a
 href="http://emeld.org/school/classroom/metadata/bp-metadata.html">E-MELD's
guidelines
on
OLAC
metadata
standards.</a>&nbsp; Include as much of
that stuff as you can, but at a minimum, include your name, the
consultant's name, the name of the language you're working on, what the
file is about, what format the file is, and the date it was
created.&nbsp; An example metadata tag:<br>
<br>
Creator: Anna Belew<br>
Contributors: Ariane Ngabeu<br>
Language: Medumba,<a
 href="http://www.ethnologue.com/14/show_language.asp?code=BYV"> byv</a><a
 href="ttp://www.ethnologue.com/show_language.asp?code=byv">,</a>
Bangangte<br>
Coverage: Relative clause structures<br>
Date: 09/28/2009<br>
Format: mp3<br>
Comments: Blah blah blah here's what I have to say about this file.<br>
<br>
<br>
<br>
<span style="font-weight: bold;"><br>
<span style="font-weight: bold;"><a name="naming"></a>Name my audio
files?<br>
</span></span><br>
For now, use the following system:<br>
<br>
<span style="font-style: italic;">Naming individual files: </span><br>
<br>
[your name] plus a six-digit number-- for example, Andrei might upload
Andrei000001, Andrei000002, up through Andrei000125.&nbsp; It doesn't
really matter if they're consecutive, this is more for your
organization than anything else.<br>
<br>
<span style="font-style: italic;">Naming session files:</span><br>
<br>
Session files (the unedited recordings of your elicitation sessions)
should be named by their date, your name, and which chunk of the
session they are.&nbsp; For example, if Katie has a one-hour
elicitation session on April 10, 2010, broken up into four 15-minute
files, she'd name the files like this:<br>
<br>
Katie041010a.mp3<br>
Katie041010b.mp3<br>
Katie041010c.mp3<br>
Katie041010d.mp3<br>
<br>
This system helps us keep track of when sessions were held, and with
whom, in case the metadata is somehow lost.<br>
<br>
<br>
</body>
</div>
</html>
