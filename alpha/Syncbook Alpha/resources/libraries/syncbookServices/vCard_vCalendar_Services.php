<?php
    use Sabre\VObject;
    include '../sabredav/vendor/autoload.php';
    
    /*========== ||||| ===== vCard Operations ===== ||||| ==========*/
    
    echo("<HTML>\n\t<BODY>\n\t\t<CENTER>\n\t\t\t<DIV STYLE=\"COLOR: BLUE;\">\n\t\t\t\t<H1>vCard Operations</H1>\n\t\t\t</DIV>\n\t\t</CENTER>\n\t</BODY>\n</HTML><CENTER>");
    
    /*Opening vCards*/
    echo("<B>----------::::::::::----------Opening vCards----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCardReadExample = VObject\Reader::read(fopen("./vCardStorage/FedericoLonghin.vcf","r"));
    
    /*To do in case Broken Software generated the vCard*/
    // $vCardReadExample = VObject\Reader::read(fopen("./FedericoLonghin.vcf","r"), VObject\Reader::OPTION_FORGIVING);
    
    echo("vCardReadExample * FN : -|".$vCardReadExample->FN."|- Should Output -|Federico Longhin|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Creating vCards*/
    echo("<B>----------::::::::::----------Creating vCards----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCardBuildExample = new VObject\Component\VCard([
        'FN'  => 'Federico Longhin',
        'TEL' => '+1 555 34567 455',
        'N'   => ['Federico', 'Longhin', '', 'Dr.', 'MD'],
        'BUILDTEST' => 'Build Test',
    ]);
    
    echo("vCardBuildExample * BUILDTEST : -|".$vCardBuildExample->BUILDTEST."|- Should Output -|Buil Test|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Print a BuildCard serialize() [String verison of the vCard]
    echo("Print a BuildCard serialize() : ".$vCardBuildExample->serialize());
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Serialize vCards <-> JSON*/
    echo("<B>----------::::::::::----------Serialize vCards <-> JSON (jCards)----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $jCardReadExample = json_encode($vCardReadExample->jsonSerialize());
    $jCardBuildExample = json_encode($vCardBuildExample->jsonSerialize());
    
    echo("<B>jCardReadExample : </B>".$jCardReadExample);
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("<B>jCardBuildExample : </B>".$jCardBuildExample);
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Adding properties*/
    echo("<B>----------::::::::::----------Adding properties----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCardReadExample->add('VCARDREADEXAMPLEADD', 'vCardReadExampleAdd');
    $vCardBuildExample->add('VCARDBUILDEXAMPLEADD', 'vCardBuildExampleAdd');
    
    echo("vCardReadExample * VCARDREADEXAMPLEADD : -|".$vCardReadExample->VCARDREADEXAMPLEADD."|- Should Output -|vCardReadExampleAdd|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCardBuildExample * VCARDBUILDEXAMPLEADD : -|".$vCardBuildExample->VCARDBUILDEXAMPLEADD."|- Should Output -|vCardBuildExampleAdd|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Manipulating properties*/
    echo("<B>----------::::::::::----------Manipulating properties----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Adding Properties to Mod
    $vCardReadExample->add('VCARDREADEXAMPLEMANIPULATE', 'vCardReadExample');
    $vCardBuildExample->add('VCARDBUILDEXAMPLEMANIPULATE', 'vCardBuildExample');
    
    // Manipulating Properties added above
    $vCardReadExample->VCARDREADEXAMPLEMANIPULATE ='vCardReadExampleManipulate';
    $vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE = 'vCardBuildExampleManipulate';
    
    echo("vCardReadExample * VCARDREADEXAMPLEMANIPULATE : -|".$vCardReadExample->VCARDREADEXAMPLEMANIPULATE."|- Should Output -|vCardReadExampleManipulate|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCardBuildExample * VCARDBUILDEXAMPLEMANIPULATE : -|".$vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE."|- Should Output -|vCardBuildExampleManipulate|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Removing Properties added above
    unset($vCardReadExample->VCARDREADEXAMPLEMANIPULATE);
    unset($vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE);
    
    echo("vCardReadExample * VCARDREADEXAMPLEMANIPULATE : -|".$vCardReadExample->VCARDREADEXAMPLEMANIPULATE."|- Should Output -||-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCardBuildExample * VCARDBUILDEXAMPLEMANIPULATE : -|".$vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE."|- Should Output -||-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Checking existence of Properties added above
    if(isset($vCardReadExample->VCARDREADEXAMPLEMANIPULATE) || isset($vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE)) {
        echo("Properties vCardReadExample->VCARDREADEXAMPLEMANIPULATE || vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE are Set");
        echo("<HTML><BODY></BR></BR></BODY></HTML>");
    } else {
        echo("Properties vCardReadExample->VCARDREADEXAMPLEMANIPULATE || vCardBuildExample->VCARDBUILDEXAMPLEMANIPULATE are NotSet");
        echo("<HTML><BODY></BR></BR></BODY></HTML>");
    }
    
    /*Working with parameters*/
    echo("<B>----------::::::::::----------Working with parameters----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCardReadExample->add('VCARDREADEXAMPLEWORKING', 'vCardReadExampleWorking');
    $vCardBuildExample->add('VCARDBUILDEXAMPLEWORKING', 'vCardBuildExampleWorking');
    
    $vCardReadExampleWorkingParam = $vCardReadExample->VCARDREADEXAMPLEWORKING;
    $vCardBuildExampleWorkingParam = $vCardBuildExample->VCARDBUILDEXAMPLEWORKING;
    
    echo("vCardReadExample * VCARDREADEXAMPLEWORKING : -|".$vCardReadExampleWorkingParam."|- Should Output -|vCardReadExampleWorking|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCardBuildExample * VCARDBUILDEXAMPLEWORKING : -|".$vCardBuildExampleWorkingParam."|- Should Output -|vCardBuildExampleWorking|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Directly reading propery values*/
    echo("<B>----------::::::::::----------Directly reading propery values----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Single property with more parts
    echo("How a property with more parts is coded : </BR>");
    print_r($vCardReadExample->N->getParts());
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    echo("How a property with more parts can be printed : </BR>");
    $auxiliarArray = $vCardReadExample->N->getParts();
    for($i=0; $i<count($auxiliarArray); $i++) {
        echo("| Part*".$i." = ".$auxiliarArray[$i]." |");
    }
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Converting vCard Version*/
    echo("<B>----------::::::::::----------Converting vCard Version----------::::::::::----------</B>");
    echo("</BR></BR><B STYLE=\"COLOR : RED;\">NOT POSSIBLE WITH SABREDAV SO NO CHANGE HAS BEEN DONE</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCardReadExample = VObject\Reader::read(fopen("./vCardStorage/FedericoLonghin.vcf","r"));
    echo("vCard Serialize 3.0 : ".$vCardReadExample->serialize());
    echo("<HTML><BODY></BR></BODY></HTML>");
    
    // Not possible with SabreDav
    $vCardReadExample->convert(VObject\Document::VCARD40);
    
    echo("<HTML><BODY></BR></BODY></HTML>");
    echo("vCard Serialize 4.0 : ".$vCardReadExample->serialize());
    echo("<HTML><BODY></BR></BR><HR></BODY></HTML>");
    
    /*========== ||||| ===== vCalendar Operations ===== ||||| ==========*/
    
    echo("<HTML>\n\t<BODY>\n\t\t<CENTER>\n\t\t\t<DIV STYLE=\"COLOR: BLUE;\">\n\t\t\t\t<H1>vCalendar Operations</H1>\n\t\t\t</DIV>\n\t\t</CENTER>\n\t</BODY>\n</HTML><CENTER>");
    
    /*Opening vCalendars*/
    echo("<B>----------::::::::::----------Opening vCalendars----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendarReadExample = VObject\Reader::read(fopen("./vCalendarStorage/EventTest.ics","r"));
    
    echo("vCalendarReadExample * CALSCALE : -|".$vCalendarReadExample->CALSCALE."|- Should Output -|GREGORIAN|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Creating vCalendars*/
    echo("<B>----------::::::::::----------Creating vCalendars----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendarBuildExample = new VObject\Component\VCalendar([
        'CALSCALE'  => 'GREGORIAN',
        'LOCATION' => 'Build Location',
        'DESCRIPTION' => 'Build Description',
        'URL' => 'www.google.com',
        'CUSTOMTEST' => 'Custom Test',
        'DTSTART' => new \DateTime('1996-08-21 11:05:00', new \DateTimeZone('UTC')),
        'DTEND' => new \DateTime('1996-08-21 12:05:00', new \DateTimeZone('UTC')),
    ]);
    
    echo("vCalendarBuildExample * CUSTOMTEST : -|".$vCalendarBuildExample->CUSTOMTEST."|- Should Output -|Custom Test|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Print a BuildCalendar serialize() [String verison of the vCalendar]
    echo("Print a BuildCalendar serialize() : ".$vCalendarBuildExample->serialize());
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Serialize vCalendars <-> JSON*/
    echo("<B>----------::::::::::----------Serialize vCalendars <-> JSON (jCalendars)----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $jCalendarReadExample = json_encode($vCalendarReadExample->jsonSerialize());
    $jCalendarBuildExample = json_encode($vCalendarBuildExample->jsonSerialize());
    
    echo("<B>jCalendarReadExample : </B>".$jCalendarReadExample);
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("<B>jCalendarBuildExample : </B>".$jCalendarBuildExample);
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Adding properties*/
    echo("<B>----------::::::::::----------Adding properties----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendarReadExample->add('VCALENDARREADEXAMPLEADD', 'vCalendarReadExampleAdd');
    $vCalendarBuildExample->add('VCALENDARBUILDEXAMPLEADD', 'vCalendarBuildExampleAdd');
    
    echo("vCalendarReadExample * VCALENDARREADEXAMPLEADD : -|".$vCalendarReadExample->VCALENDARREADEXAMPLEADD."|- Should Output -|vCalendarReadExampleAdd|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCalendarBuildExample * VCALENDARBUILDEXAMPLEADD : -|".$vCalendarBuildExample->VCALENDARBUILDEXAMPLEADD."|- Should Output -|vCalendarBuildExampleAdd|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Manipulating properties*/
    echo("<B>----------::::::::::----------Manipulating properties----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Adding Properties to Mod
    $vCalendarReadExample->add('VCALENDARREADEXAMPLEMANIPULATE', 'vCalendarReadExample');
    $vCalendarBuildExample->add('VCALENDARBUILDEXAMPLEMANIPULATE', 'vCalendarBuildExample');
    
    // Manipulating Properties added above
    $vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE ='vCalendarReadExampleManipulate';
    $vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE = 'vCalendarBuildExampleManipulate';
    
    echo("vCalendarReadExample * VCALENDARREADEXAMPLEMANIPULATE : -|".$vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE."|- Should Output -|vCalendarReadExampleManipulate|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCalendarBuildExample * VCALENDARBUILDEXAMPLEMANIPULATE : -|".$vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE."|- Should Output -|vCalendarBuildExampleManipulate|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Removing Properties added above
    unset($vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE);
    unset($vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE);
    
    echo("vCalendarReadExample * VCALENDARREADEXAMPLEMANIPULATE : -|".$vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE."|- Should Output -||-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCalendarBuildExample * VCALENDARBUILDEXAMPLEMANIPULATE : -|".$vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE."|- Should Output -||-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    // Checking existence of Properties added above
    if(isset($vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE) || isset($vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE)) {
        echo("Properties vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE || vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE are Set");
        echo("<HTML><BODY></BR></BR></BODY></HTML>");
    } else {
        echo("Properties vCalendarReadExample->VCALENDARREADEXAMPLEMANIPULATE || vCalendarBuildExample->VCALENDARBUILDEXAMPLEMANIPULATE are NotSet");
        echo("<HTML><BODY></BR></BR></BODY></HTML>");
    }
    
    /*Working with parameters*/
    echo("<B>----------::::::::::----------Working with parameters----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendarReadExample->add('VCALENDARREADEXAMPLEWORKING', 'vCalendarReadExampleWorking');
    $vCalendarBuildExample->add('VCALENDARBUILDEXAMPLEWORKING', 'vCalendarBuildExampleWorking');
    
    $vCalendarReadExampleWorkingParam = $vCalendarReadExample->VCALENDARREADEXAMPLEWORKING;
    $vCalendarBuildExampleWorkingParam = $vCalendarBuildExample->VCALENDARBUILDEXAMPLEWORKING;
    
    echo("vCalendarReadExample * VCALENDARREADEXAMPLEWORKING : -|".$vCalendarReadExampleWorkingParam."|- Should Output -|vCalendarReadExampleWorking|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    echo("vCalendarBuildExample * VCALENDARBUILDEXAMPLEWORKING : -|".$vCalendarBuildExampleWorkingParam."|- Should Output -|vCalendarBuildExampleWorking|-");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Date and Time Handling*/
    echo("<B>----------::::::::::----------Date and Time Handling----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $startReadEvent = $vCalendarReadExample->VEVENT->DTSTART->getDateTime();
    echo("vCalendarReadExample Event Start : ".$startReadEvent->format(\DateTime::W3C)."</BR>");
    $endReadEvent = $vCalendarReadExample->VEVENT->DTEND->getDateTime();
    echo("vCalendarReadExample Event End : ".$endReadEvent->format(\DateTime::W3C)."</BR></BR>");
    
    $startBuildEvent = $vCalendarBuildExample->DTSTART->getDateTime();
    echo("vCalendarBuildExample Event Start : ".$startBuildEvent->format(\DateTime::W3C)."</BR>");
    $endBuildEvent = $vCalendarBuildExample->DTEND->getDateTime();
    echo("vCalendarBuildExample Event End : ".$endBuildEvent->format(\DateTime::W3C));
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Recurrence Handling*/
    echo("<B>----------::::::::::----------Recurrence Handling----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendar = VObject\Reader::read(fopen("./vCalendarStorage/RecurrenceHandling.ics","r"));
    $vCalendar->expand(new DateTime('2012-01-01'), new DateTime('2012-12-31'));
    echo("Serializing Events</BR></BR>".$vCalendar->serialize());
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    /*Free - Busy Report Generator*/
    echo("<B>----------::::::::::----------Free - Busy Report Generator----------::::::::::----------</B>");
    echo("<HTML><BODY></BR></BR></BODY></HTML>");
    
    $vCalendar = VObject\Reader::read(fopen("./vCalendarStorage/RecurrenceHandling.ics","r"));
    $fbGenerator = new VObject\FreeBusyGenerator(new DateTime('2012-01-01'), new DateTime('2012-12-31'), $vCalendar);
    $freebusy = $fbGenerator->getResult();
    echo("Serializing Free - Busy</BR></BR>".$freebusy->serialize());
?>