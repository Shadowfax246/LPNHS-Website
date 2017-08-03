document.addEventListener("DOMContentLoaded", function(){
    firebase.auth().onAuthStateChanged(firebaseUser => {
        if(firebaseUser){
            console.log(firebaseUser);
            
            var leadershipList = document.getElementById("leadership");
            var studentList = document.getElementById("students");
            var addUserTable = document.getElementById("addUserTable");
            var permissions = "";
            
            firebase.database().ref("/Users/" + firebaseUser.uid).once("value").then(function(snapshot){
                permissions = snapshot.val().permissions;
                
                if(permissions==="admin"){
                    document.styleSheets[1].insertRule("table.listing th, td{width: 20%;}", 0);
                }
                else{
                    document.styleSheets[1].insertRule("table.listing th, td{width: 50%;}", 0);
                }
                
                //create table head
                for(var i = 0; i<2; i++){
                    var thead = document.createElement("thead");
                    var tr = document.createElement("tr");
                    var nameTH = document.createElement("th");
                        nameTH.innerHTML = "Name";
                    var emailTH = document.createElement("th");
                        emailTH.innerHTML = "Email";
                    tr.appendChild(nameTH);
                    tr.appendChild(emailTH);
                    if(permissions==="admin"){
                        var hoursTH = document.createElement("th");
                            hoursTH.innerHTML = "Hours";
                        tr.appendChild(hoursTH);
                        
                        var permissionsTH = document.createElement("th");
                            permissionsTH.innerHTML = "Permissions";
                        tr.appendChild(permissionsTH);
                        
                        var removeTH = document.createElement("th");
                            removeTH.innerHTML = "Remove";
                        tr.appendChild(removeTH);
                    }
                    thead.appendChild(tr);
                    if(i===0){
                        leadershipList.appendChild(thead);
                    }
                    else if(i===1){
                        studentList.appendChild(thead);
                    }
                }
                
                //create addUser table
                var thead = document.createElement("thead");
                    var tr = document.createElement("tr");
                    var firstNameTH = document.createElement("th");
                        firstNameTH.innerHTML = "First Name";
                    var lastNameTH = document.createElement("th");
                        lastNameTH.innerHTML = "Last Name";
                    var emailTH = document.createElement("th");
                        emailTH.innerHTML = "Email";
                    var idTH = document.createElement("th");
                        idTH.innerHTML = "Student ID";
                    var vpTH = document.createElement("th");
                        vpTH.innerHTML = "Vice President";
                    var hoursTH = document.createElement("th");
                        hoursTH.innerHTML = "Initial Hours";
                    var permissionsTH = document.createElement("th");
                        permissionsTH.innerHTML = "Permissions";
                
                    tr.appendChild(firstNameTH);
                    tr.appendChild(lastNameTH);
                    tr.appendChild(emailTH);
                    tr.appendChild(idTH);
                    tr.appendChild(vpTH);
                    tr.appendChild(hoursTH);
                    tr.appendChild(permissionsTH);
                    thead.appendChild(tr);
                addUserTable.appendChild(thead);
                    
                    //create inputs
                    var tbody = document.createElement("tbody");
                    var row = document.createElement("tr");
                    var firstNameTD = document.createElement("td");
                        var firstNameInput = document.createElement("input");
                        firstNameInput.id = "addUserFirstName";
                        firstNameTD.appendChild(firstNameInput);
                    var lastNameTD = document.createElement("td");
                        var lastNameInput = document.createElement("input");
                        lastNameInput.id = "addUserLastName";
                        lastNameTD.appendChild(lastNameInput);
                    var emailTD = document.createElement("td");
                        var emailInput = document.createElement("input");
                        emailInput.id = "addUserEmail";
                        emailTD.appendChild(emailInput);
                    var idTD = document.createElement("td");
                        var idInput = document.createElement("input");
                        idInput.id = "addUserId";
                        idTD.appendChild(idInput);
                    var vpTD = document.createElement("td");
                        var vpInput = document.createElement("input");
                        vpInput.id = "addUserVP";
                        vpTD.appendChild(vpInput);
                    var hoursTD = document.createElement("td");
                        var hoursInput = document.createElement("input");
                        hoursInput.id = "addUserHours";
                        hoursInput.type = "number";
                        hoursInput.setAttribute("min", "0");
                        hoursInput.setAttribute("step", "any");
                        hoursInput.value = 0;
                        hoursTD.appendChild(hoursInput);
                    var permissionsTD = document.createElement("td");
                        var permissionsInput = document.createElement("select");
                        var optionStudent = document.createElement("option");
                            optionStudent.value = "student";
                            optionStudent.innerHTML = "student";
                        var optionAdmin = document.createElement("option");
                            optionAdmin.value = "admin";
                            optionAdmin.innerHTML = "admin";
                        permissionsInput.appendChild(optionStudent);
                        permissionsInput.appendChild(optionAdmin);
                        permissionsTD.appendChild(permissionsInput);
                    var submitTD = document.createElement("td");
                        var submitButton = document.createElement("button");
                        submitButton.type = "button";
                        submitButton.classList.add("classicColor");
                        submitButton.innerHTML = "Create User";
                        submitButton.addEventListener("click", function(){
                            //setup second firebase app (to avoid logging out admin)
                            var config = {
                                apiKey: "AIzaSyByQW8Cyp9yAIMm5xCrNZqF-5kqJ-w6g-4",
                                authDomain: "nhs-project-test.firebaseapp.com",
                                databaseURL: "https://nhs-project-test.firebaseio.com",
                                projectId: "nhs-project-test",
                                storageBucket: "nhs-project-test.appspot.com",
                                messagingSenderId: "239221174231"
                            };
                            var secondaryApp = firebase.initializeApp(config, "secondary");
                            //create User --password is studentID--
                            secondaryApp.auth().createUserWithEmailAndPassword(emailInput.value, idInput.value).catch(function(error){
                                alert(error.message + " Error Code: " + error.code);
                            }).then(function(newUser){
                                //add user to database
                                var updates = {};
                                updates["/Users/" + newUser.uid] = {
                                    email: emailInput.value,
                                    firstName: firstNameInput.value,
                                    lastName: lastNameInput.value,
                                    id: idInput.value,
                                    permissions: permissionsInput.value,
                                    vicePresident: vpInput.value,
                                    hoursCompleted: hoursInput.value,
                                    disabled: "false"
                                };
                                firebase.database().ref().update(updates).then(function(){
                                    //clear inputs
                                    firstNameInput.value = "";
                                    lastNameInput.value = "";
                                    emailInput.value = "";
                                    idInput.value = "";
                                    vpInput.value = "";
                                    hoursInput.value = "";
                                    
                                    alert("User created with student ID as password");
                                });
                            });
                        });
                        submitTD.appendChild(submitButton);
                    row.appendChild(firstNameTD);
                    row.appendChild(lastNameTD);
                    row.appendChild(emailTD);
                    row.appendChild(idTD);
                    row.appendChild(vpTD);
                    row.appendChild(hoursTD);
                    row.appendChild(permissionsTD);
                    row.appendChild(submitTD);
                    
                    tbody.appendChild(row);
                    addUserTable.appendChild(tbody);
                
                if(permissions === "admin"){
                    document.getElementById("addUserDiv").classList.remove("vanish");
                }
                
                var i = 0;
                firebase.database().ref("/Users").orderByChild("lastName").once("value").then(function(snapshot){
                    snapshot.forEach(function(childSnapshot){
                        if(childSnapshot.val().disabled!=="true"){
                            var studentTR = document.createElement("tr");

                            var studentName = document.createElement("td");
                                studentName.innerHTML = childSnapshot.val().firstName + " " + childSnapshot.val().lastName;
                                studentName.dataset.userId = childSnapshot.key;
                            var studentEmail = document.createElement("td");
                                studentEmail.innerHTML = childSnapshot.val().email;

                            studentTR.appendChild(studentName);
                            studentTR.appendChild(studentEmail);
                            if(permissions==="admin"){
                                var studentHours = document.createElement("td");
                                    studentHours.innerHTML = childSnapshot.val().hoursCompleted;
                                var studentPermissionsTD = document.createElement("td");
                                var studentPermissions = document.createElement("select");
                                    studentPermissions.id = "permissionsInput" + i;
                                    var optionAdmin = document.createElement("option");
                                        optionAdmin.value = "admin";
                                        optionAdmin.innerHTML = "admin";
                                    var optionStudent = document.createElement("option");
                                        optionStudent.value = "student";
                                        optionStudent.innerHTML = "student";
                                    if(childSnapshot.val().permissions === "admin"){
                                        optionAdmin.setAttribute("selected", "selected");
                                    }
                                    else if(childSnapshot.val().permissions === "student"){
                                        optionStudent.setAttribute("selected", "selected");
                                    }
                                var permissionsButton = document.createElement("button");
                                    permissionsButton.innerHTML = "Submit Changes";
                                    permissionsButton.style = "margin: 0 10px;"
                                    permissionsButton.type = "button";
                                    permissionsButton.classList.add("classicColor");
                                    permissionsButton.id = "permissionsButton" + i;
                                permissionsButton.addEventListener("click", function(){
                                    var n = this.id.substring(this.id.length - 1);

                                    var updates = {};
                                    updates["/Users/" + childSnapshot.key + "/permissions"] = document.getElementById("permissionsInput" + n).value;

                                    firebase.database().ref().update(updates).then(function(){
                                        alert("Permissions updated");
                                        window.location.replace(window.location.href);
                                    });
                                });

                                var removeTD = document.createElement("td");
                                var removeButton = document.createElement("button");
                                    removeButton.innerHTML = "Remove";
                                    removeButton.type = "button";
                                    removeButton.classList.add("classicColor");
                                    removeButton.style = "background-color: red";
                                removeButton.addEventListener("click", function(){
                                    if(confirm("Disable this user? This cannot be undone.")){
                                        var updates = {};
                                        updates["/Users/" + childSnapshot.key + "/disabled"] = "true";
                                        firebase.database().ref().update(updates).then(function(){
                                            alert("User disabled");
                                            window.location.replace(window.location.href);
                                        });
                                    }
                                });
                                removeTD.appendChild(removeButton);

                                studentPermissions.appendChild(optionAdmin);
                                studentPermissions.appendChild(optionStudent);
                                studentPermissionsTD.appendChild(studentPermissions);
                                studentPermissionsTD.appendChild(permissionsButton);

                                studentTR.appendChild(studentHours);
                                studentTR.appendChild(studentPermissionsTD);
                                studentTR.appendChild(removeTD);
                            }

                            if(childSnapshot.val().permissions === "student"){
                                studentList.appendChild(studentTR);
                            }
                            else{
                                leadershipList.appendChild(studentTR);
                            }

                            i++;
                        }
                    });
                });
            });
        }
    });
});