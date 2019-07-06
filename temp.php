<table id="myTable">
    <tr class='lead-table-header'>
        <th></th>
        <th onclick="sortTable(1), changeIcon(0)">Full Name  <i id="sort-icon-0" class=" fas fa-sort"></i></th>
        <th onclick="sortTable(2), changeIcon(1)">Company <i id="sort-icon-1"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(3), changeIcon(2)">Partner <i id="sort-icon-2"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(4), changeIcon(3)">Partner Rep <i id="sort-icon-3"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(5), changeIcon(4)">Assigned to <i id="sort-icon-4"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(6), changeIcon(5)">Office Phone <i id="sort-icon-5"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(7), changeIcon(6)">Email <i id="sort-icon-6"  class=" fas fa-sort"></i></th>
        <th onclick="sortTable(8), changeIcon(7)">Last Contacted <i id="sort-icon-7"  class=" fas fa-sort"></i></th>
    </tr>


    <?php

    if(!empty($lead->getLeads())) {

        foreach ($lead->getLeads() as $lead) {

            if ($lead->lastContacted == null)
                $lastContacted = '-';
            else
                $lastContacted = $lead->lastContacted;


            echo "
                    
                        <tr class='lead-table-row'>
                    <td><a href='info.php?case=lead&id={$lead->id}'><i class='fas fa-external-link-alt' style='color: rgba(0,0,0,.8)'></i></a></td>    
                    <td>{$lead->firstName} {$lead->lastName}</td>
                    <td>{$lead->company}</td>
                    <td>{$lead->partner}</td>
                    <td>{$lead->partnerRep}</td>
                    <td>{$lead->assignedTo}</td>
                    <td>{$lead->officePhone}</td>
                    <td>{$lead->email}</td>
                    <td>{$lastContacted}</td>
                    
                </tr>
                    
                    ";


        }
    }else{
        echo "
                
                    <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
                
                ";
    }

    ?>

</table>