-- สร้างตาราง tbldepartments
CREATE TABLE tbldepartments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    DepartmentName VARCHAR(150),
    DepartmentShortName VARCHAR(100),
    DepartmentCode VARCHAR(50),
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- สร้างตาราง tblemployees
CREATE TABLE tblemployees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    EmpId VARCHAR(100) NOT NULL,
    FirstName VARCHAR(150),
    LastName VARCHAR(150),
    EmailId VARCHAR(200),
    Password VARCHAR(180),
    Gender VARCHAR(100),
    Dob DATE,
    Department INT,
    Address VARCHAR(255),
    City VARCHAR(200),
    Country VARCHAR(150),
    Phonenumber CHAR(11),
    Status INT(1),
    RegDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    HireDate DATE NOT NULL,
    Position VARCHAR(100),
    FOREIGN KEY (Department) REFERENCES tbldepartments(id)
);

-- สร้างตาราง tblleavetype
CREATE TABLE tblleavetype (
    id INT AUTO_INCREMENT PRIMARY KEY,
    LeaveType VARCHAR(200),
    Description MEDIUMTEXT,
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    MaxDays INT
);

-- สร้างตาราง tblleaves
CREATE TABLE tblleaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    LeaveType INT,
    ToDate DATE,
    FromDate DATE,
    Description MEDIUMTEXT,
    PostingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AdminRemark MEDIUMTEXT,
    AdminRemarkDate DATE,
    Status INT(1),
    IsRead INT(1),
    empid INT,
    ApprovalDate DATE,
    FOREIGN KEY (LeaveType) REFERENCES tblleavetype(id),
    FOREIGN KEY (empid) REFERENCES tblemployees(id)
);

-- สร้างตาราง tblleaveentitlement
CREATE TABLE tblleaveentitlement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    LeaveTypeID INT,
    YearsOfService INT,
    EntitledDays INT,
    FOREIGN KEY (LeaveTypeID) REFERENCES tblleavetype(id)
);

-- สร้างตาราง admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(100) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    updationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Role VARCHAR(50)
);