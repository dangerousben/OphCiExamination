
    
/**
  * Populate the second list according to the values held in the first
  * list. When selecting the first list choice, if id_list3 is not null, it's
  * style display value is set to none, only being set to inline of the
  * second list has at least one value in it (not including a 'Please
  * select' option.
  *
  * id_list1 the first list of choices1 to examine; this will not
  * be changed, and will be used to influence the values in the
  * second list. It is a div element.
  * 
  * id_list2 the second list that will be influenced by the contents
  * of the first list. It is a div element.
  * 
  * id_list3 a third list option, if necessary. Can be null; it's contents is
  * not populated, but it's visibility is set according to whether or not
  * the second list is populated or not. Like id_list1 and id_list2, this
  * should be a div element.
  * 
  * groupRemoval an associative array of array(string:int) => string(groupName)
  * values.
  * 
  * choices1 an associateive array of string(value) => string(group) elements
  * to be placed in the select in the div id_list1. This will influence the
  * choice of the second list.
  * 
  * choices2 an empty array; this list will be added to as we examine choices1.
  */
function populateList(id_list1, id_list2, id_list3,
                               groupRemoval, choices1, choices2) {
                            
    document.getElementById(id_list2).style.display = "none";
    if (document.getElementById(id_list3) != null) {
        document.getElementById(id_list3).style.display = "none";
    }
    // get each list so we can populate and interrogate them appropriately:
    var list1 = document.getElementById(id_list1);
    var list2 = document.getElementById(id_list2);
    // which element is selected in the first list?
    var index = list1.selectedIndex;
    // only display the list if the next list is not empty - we'll update
    // this if there are still choices to select once the second list is
    // populated:
    var displayNextList = false;
    // get the name of the currently selected medication:
    var list1SelectedName = list1.options[index].text;
    var options = list1.options;
    list2.options.length = 0; // - empty list 2 of any items
    option = list2.options[list2.options.length] =
        new Option("- Please Select -","");
    for (var i = 1; i < options.length; i++) {
        var isToRemove = false;
        // does the group removal contain the specified group?
        if (groupRemoval[choices1[list1SelectedName]]) {
            // if so, check all groups for the specified name:
            for (var k = 0; k < groupRemoval[choices1[list1SelectedName]].length; k++) {
                // yes - found a match. We do not want to include the values
                // from this group:
                if (choices1[options[i].text] == groupRemoval[choices1[list1SelectedName]][k]) {
                    isToRemove = true;
                    break;
                }
            }
            if (!isToRemove) {
                // we want to include the values from the specified element from
                // the first list:
                displayNextList = true;
                choices2[choices2.length] = options[i].text;
                option = list2.options[list2.options.length] = new Option(options[i].text,""); 
                option.value = options[i].value;
            }
        }
    }
    // the list should now only be populated with valid groups NOT conflicting
    // with previous choices:
    if (displayNextList && list2.options.length > 1) {
        // we need to show list 2 - so show it:
        document.getElementById(id_list2).style.display = "inline";
    }
}