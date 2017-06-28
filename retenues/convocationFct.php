<?php
function txtmonth($month)
{
 $monthlist=array(1=>'janvier',2=>'février',3=>'mars',4=>'avril',5=>'mai',6=>'juin',
    7=>'juillet',8=>'août',9=>'septembre',10=>'octobre',11=>'novembre',12=>'décembre');
 return $monthlist[(int)$month];
}

function txtday($code)
{
 $daylist=array(0=>'dimanche',1=>'lundi',2=>'mardi',3=>'mercredi',4=>'jeudi',5=>'vendredi',6=>'samedi');
 return $daylist[(int)$code];
}

function rang($nb)
{
 $temp=array(1=>'première',2=>'deuxième',3=>'troisième',4=>'quatrième',5=>'cinquième',6=>'sixième',
   7=>'septième',8=>'huitième',9=>'neuvième',10=>'dixième',11=>'onzième',12=>'douzième',13=>'treizième',
   14=>'quatorzième',15=>'quinzième',16=>'seizième',17=>'dix-septième',18=>'dix-huitième',19=>'dix-neuvième',20=>'vingtième',
   21=>'vingt et unième',22=>'vingt-deuxième',23=>'vingt-troisième',24=>'vingt-quatrième',25=>'vingt-cinquième',26=>'vingt-sixième',
   27=>'vingt-septième',28=>'vingt-huitième',29=>'vingt-neuvième',30=>'trentième',31=>'trente et unième',32=>'trente-deuxième',33=>'trente-troisième',
   34=>'trente-quatrième',35=>'trente-cinquième',36=>'trente-sixième',37=>'trente-septième',38=>'trente-huitième',39=>'trente-neuvième'
);
 return $temp[(int)$nb];
}
?>
