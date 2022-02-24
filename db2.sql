DROP TABLE IF EXISTS Has_Cart;
DROP TABLE IF EXISTS In_Cart;
DROP TABLE IF EXISTS Shopping_Cart;
DROP TABLE IF EXISTS Is_Rated;
DROP TABLE IF EXISTS Rates;
DROP TABLE IF EXISTS Rating;
DROP TABLE IF EXISTS On_Wishlist;
DROP TABLE IF EXISTS Guest;
DROP TABLE IF EXISTS In_Order;
DROP TABLE IF EXISTS Trade;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Book;
DROP TABLE IF EXISTS Publisher;
DROP TABLE IF EXISTS Has_Pay_Info;
DROP TABLE IF EXISTS Payment_Info;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS User;

CREATE TABLE User(
	Email VARCHAR(40) PRIMARY KEY,
	Name  VARCHAR(26) NOT NULL,
	Phone VARCHAR(11) NOT NULL	
);

INSERT INTO User VALUES('elmo@gmail.com', 'Elmo Sesame', '5556667777');
INSERT INTO User VALUES('larry_david@gmail.com', 'Larry David', '911');
INSERT INTO User VALUES('jerry@gmail.com', 'Jerry Seinfeld', '411');
INSERT INTO User VALUES('barney@gmail.com', 'Barney Dinosaur', '7965326565');
INSERT INTO User VALUES('spongebob@gmail.com', 'Spongebob Squarepants', '5556767777');
INSERT INTO User VALUES('cookie@verizon.net', 'Cookie Dog', '1234567890');
INSERT INTO User VALUES('ojsimp@hotmail.com', 'OJ Simpson', '3734567897');
INSERT INTO User VALUES('bobsbugsbegone@gmail.com', 'Bob Duncan', '4546675464');
INSERT INTO User VALUES('imricherthanyou@rcn.com', 'Bill Gates', '9998887777');
INSERT INTO User VALUES('tesla@gmail.com', 'Elon Musk', '5657678877');

INSERT INTO User VALUES('Scholastic@gmail.com', 'Peter Warwick', '73878347');
INSERT INTO User VALUES('Boombastic@yahoo.com', 'Biggie Cheese', '489328747');
INSERT INTO User VALUES('McGraw@gmail.com', 'Simon Allen', '1238914914');
INSERT INTO User VALUES('hcollins@gmail.com', 'Brian Murray', '18002427737');
INSERT INTO User VALUES('hachette@gmail.com', 'Arnaud Nourry', '6785857658');

CREATE TABLE Customer (
	Email VARCHAR(40),
	Username VARCHAR(20) NOT NULL,
	Password VARCHAR(20) NOT NULL,
	Membership BOOLEAN,
	FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE
	ON UPDATE CASCADE
);

INSERT INTO Customer VALUES('elmo@gmail.com', 'elmo', 'password', False);
INSERT INTO Customer VALUES('larry_david@gmail.com', 'LDMaster', 'curb',True);
INSERT INTO Customer VALUES('jerry@gmail.com', 'jerry', 'seinfeld',True);
INSERT INTO Customer VALUES('barney@gmail.com', 'dinosaur', 'taildrugs', False);
INSERT INTO Customer VALUES('spongebob@gmail.com', 'bob12', 'squarepants', False);

CREATE TABLE Guest(
	Email VARCHAR(40),
	FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE  ON 
UPDATE CASCADE
);

INSERT INTO Guest VALUES('cookie@verizon.net');
INSERT INTO Guest VALUES('ojsimp@hotmail.com');
INSERT INTO Guest VALUES('bobsbugsbegone@gmail.com');
INSERT INTO Guest VALUES('imricherthanyou@rcn.com');
INSERT INTO Guest VALUES('tesla@gmail.com');


CREATE TABLE Publisher(
	Email VARCHAR(40),
	Addr VARCHAR(40),
	Publisher_Name VARCHAR(20) UNIQUE,
	Special_Password VARCHAR(20),
	FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE ON 
UPDATE CASCADE
);

INSERT INTO Publisher VALUES('Scholastic@gmail.com', '420 Dank Avenue Boston MA', 'Scholastic', 'password1');
INSERT INTO Publisher VALUES('Boombastic@yahoo.com', '77 Barnyard Road Boston MA', 'Biggie Cheese Inc',
'cows');
INSERT INTO Publisher VALUES('McGraw@gmail.com', '2 Penn Plaza New York NY', 'McGraw Hill', 'scam_artists');
INSERT INTO Publisher VALUES('hcollins@gmail.com', '195 Broadway New York NY', 'Harper Collins', 'we_exist');
INSERT INTO Publisher VALUES('hachette@gmail.com', '1290 Avenue of the Americas Paris France', 'Hachette Livre', 'dude_trust_me');

CREATE TABLE Book(
	ISBN VARCHAR(13),
	Book_Cond VARCHAR(10),
	Title VARCHAR(20) NOT NULL,
	Author VARCHAR(30) NOT NULL,
	Edition INT,
	Genre VARCHAR(20),
	Date_Published DATE,
	Type VARCHAR(20) NOT NULL,
	Price REAL NOT NULL,
Publisher_Name VARCHAR(20),
	Stock INT NOT NULL,
	Trade_Value Real,
	PRIMARY KEY(ISBN, Book_Cond),
	FOREIGN KEY (Publisher_Name) REFERENCES Publisher(Publisher_Name) ON 
DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Book VALUES('1234455677', 'used', 'Moby Dick', 'Herman Melville', 1, 'Adventure', '1851-10-15', 'Hard Cover', 15.15, 'Harper Collins', 50, 3.00);
INSERT INTO Book VALUES('1477325925', 'new', 'The Great Gatsby', 'F Scott Fitzgerald', 0, 'Novel','1925-04-10', 'PaperBack', 5.99, 'Scholastic',102, NULL);
INSERT INTO Book VALUES('8325787825', 'new', 'A Way in the Life', 'Larry David', 5, 'Comedy', '2013-07-01', 'Digital', 7.99, 'Biggie Cheese Inc', 30, NULL);
INSERT INTO Book VALUES('8932578825', 'new', 'Cyrano De Bergerac', 'Edmond Rostand', 10, 'Drama', '1640-01-01', 'Audio', 10.99, 'Hachette Livre', 40, NULL);
INSERT INTO Book VALUES('3288324823', 'used', 'The Seinfeld Scripts', 'Larry David',9, 'Non Fiction', '1998-01-01', 'PaperBack', 10.99, 'McGraw Hill', 60, 5.00);
INSERT INTO Book VALUES('8437548384', 'used', 'If I Did It', 'OJ Simpson', 1, 'Fiction', '2007-09-07', 'Hard Cover', 10.99, 'McGraw Hill', 7, 5.00);
INSERT INTO Book VALUES('574954985945', 'used', 'Le Petit Prince', 'Antoine de Saint Exupery', 7, 'Fiction', '1943-04-06', 'PaperBack', 20.99, 'McGraw Hill', 0, 7.00);


CREATE TABLE Payment_info(
	Card_num VARCHAR(25) PRIMARY KEY,
	Name_on_card VARCHAR(26) NOT NULL,
	Bill_addr VARCHAR(40) NOT NULL,
	Exper_Date DATE NOT NULL
);

INSERT INTO Payment_info VALUES ('123456789034', 'Luke Walker', 'Maple st. 84', '2000-10-05');
INSERT INTO Payment_info VALUES ('098725431234', 'Ben Date', 'Farley st. 23', '2003-01-09');
INSERT INTO Payment_info VALUES ('879812437654', 'Fairen Height', 'Burner st. 51', '2014-08-24');
INSERT INTO Payment_info VALUES ('437827529352', 'Bob Builder', 'Peanut st 62', '2017-09-06');
INSERT INTO Payment_info VALUES ('643753458346', 'Chris Pratt', 'Mario rd. 10', '2018-03-10');

CREATE TABLE Has_Pay_Info(
	Email VARCHAR(26),
Card_num VARCHAR(25),
FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Card_num) REFERENCES Payment_info(Card_num) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Has_Pay_Info VALUES('elmo@gmail.com', '879812437654');
INSERT INTO Has_Pay_Info VALUES('ojsimp@hotmail.com', '123456789034');
INSERT INTO Has_Pay_Info VALUES('bobsbugsbegone@gmail.com', '123456789034');
INSERT INTO Has_Pay_Info VALUES('imricherthanyou@rcn.com', '098725431234');
INSERT INTO Has_Pay_Info VALUES('tesla@gmail.com', '437827529352');

CREATE TABLE Orders (
	Order_Num INT PRIMARY KEY,
	Order_Date DATE NOT NULL,
	Total_Price REAL NOT NULL,
	Email VARCHAR(26),
	Card_num VARCHAR(25),
	FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Card_num) REFERENCES Payment_info(Card_num) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Orders VALUES(100, '2012-04-01', 31.12, 'ojsimp@hotmail.com', '123456789034');
INSERT INTO Orders VALUES(101, '2013-12-31', 13.98, 'bobsbugsbegone@gmail.com', '123456789034');
INSERT INTO Orders VALUES(102, '2014-03-15', 27.96, 'imricherthanyou@rcn.com', '098725431234');
INSERT INTO Orders VALUES(103, '2015-09-09', 12.98, 'tesla@gmail.com', '098725431234');
INSERT INTO Orders VALUES(104, '2016-07-11', 19.14, 'barney@gmail.com', '098725431234');
INSERT INTO Orders VALUES(105, '2017-08-09', 5.99, 'elmo@gmail.com', '879812437654');
INSERT INTO Orders VALUES(106, '2018-09-06', 10.99, 'larry_david@gmail.com', '643753458346');
INSERT INTO Orders VALUES(107, '2018-03-01', 10.99, 'elmo@gmail.com', '879812437654');
INSERT INTO Orders VALUES(108, '2019-11-22', 5.99, 'spongebob@gmail.com', '437827529352');

	
CREATE TABLE Trade (
	Email VARCHAR(26),
	ISBN VARCHAR(13),
	Book_Cond VARCHAR(10),
	FOREIGN KEY (Email) REFERENCES Customer(Email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (ISBN, Book_Cond) REFERENCES Book(ISBN, Book_Cond) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Trade VALUES('jerry@gmail.com', '1234455677', 'used');
INSERT INTO Trade VALUES('barney@gmail.com', '3288324823', 'used');
INSERT INTO Trade VALUES('spongebob@gmail.com', '3288324823', 'used');
INSERT INTO Trade VALUES('barney@gmail.com', '1234455677', 'used');
INSERT INTO Trade VALUES('barney@gmail.com', '8437548384', 'used');


CREATE TABLE On_Wishlist (
	Email VARCHAR(26),
	ISBN VARCHAR(20),
	Book_Cond VARCHAR(10),
	FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (ISBN, Book_Cond) REFERENCES Book(ISBN, Book_Cond) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO On_Wishlist VALUES('larry_david@gmail.com', '1234455677', 'used');
INSERT INTO On_Wishlist VALUES('jerry@gmail.com', '1477325925', 'new');
INSERT INTO On_Wishlist VALUES('spongebob@gmail.com','3288324823','used');
INSERT INTO On_Wishlist VALUES('imricherthanyou@rcn.com','8437548384','used');
INSERT INTO On_Wishlist VALUES('Boombastic@yahoo.com','8932578825','new');

CREATE TABLE In_Order (
	Order_Num INT,
	ISBN VARCHAR(20),
	Book_Cond VARCHAR(10) NOT NULL,
	Quantity INTEGER NOT NULL,
	Shipping_Method VARCHAR(20) NOT NULL,
	Shipping_Addr VARCHAR(100) NOT NULL,
	Shipping_Cost REAL NOT NULL,
	FOREIGN KEY (Order_Num) REFERENCES Orders(Order_Num) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (ISBN, Book_Cond) REFERENCES Book(ISBN, Book_Cond)
);
	
INSERT INTO In_Order VALUES(100, '1234455677', 'used', 1, 'standard', 'Maple st. 84', 3.99);
INSERT INTO In_Order VALUES(100, '1477325925', 'new', 2, 'express', 'Maple st. 84', 5.99);
INSERT INTO In_Order VALUES(101, '3288324823', 'used', 1, 'standard', 'Farley st. 23', 2.99);
INSERT INTO In_Order VALUES(102, '8437548384', 'used', 2, 'standard', 'Burner st. 51', 3.99);
INSERT INTO In_Order VALUES(102, '8932578825', 'new',1, 'download', 'Curly st. 42', 1.99);
INSERT INTO In_Order VALUES(103, '8325787825', 'new',1, 'download', 'Waverly pl. 3', 4.99);
INSERT INTO In_Order VALUES(104, '1234455677', 'used',1, 'standard', 'Cod rd. 96', 3.99);
INSERT INTO In_Order VALUES(105, '1477325925', 'new',1, 'standard', 'Milk st. 105', 0);
INSERT INTO In_Order VALUES(106, '8932578825', 'new',1, 'download', 'Summer st. 5', 0);
INSERT INTO In_Order VALUES(107, '8932578825', 'new',1, 'download', 'Milk st. 105', 0);
INSERT INTO In_Order VALUES(108, '1477325925', 'new',1, 'standard', 'Friend st. 66', 0);

CREATE TABLE Rating (
	Rate_ID INTEGER PRIMARY KEY,
	Comment VARCHAR(500),
	Rating REAL NOT NULL
);
INSERT INTO Rating VALUES(5206, 'This book sucks', 1);
INSERT INTO Rating VALUES(5207, 'My wife left me again', 2);
INSERT INTO Rating VALUES(5208, 'The following is a test of a long review: ajhgajgsdkjgsdjkgsjkgsjdgjskgjjgjkjgjfjkgjfsjgjhfsgjfsjjgjsfjgjfsgjjfsjgjnbsfnjgjnsfjgrhughsfdhghsaghsjghsdagjfsjgjsadhgkfsajgnjfsaknvjsfangjfsvjkadfjgfsjaghasfjgjnfsakjvnjfadjkgfsjabnjsfagnjsfabjfagjnjakgjndkjafgjadfghadfgjnfakfngfjkadsbnakljnfgjfsaghfsjagjafjbjsfajjkbdvsbjvnjdsfvsdjvdsjgksdVuidsnjvnjkJZDVNLdsiuVnhsdjkjvdszvknzfdjkhvnsfkgvzkdngzksnvksduzvnuksdkuzvnzdskuvnhkusdghsakugjsakduglskughasuklghsadulkghsaudighdlskauhgkasudhguasdukghsakdgdggdgd', 5);
INSERT INTO Rating VALUES(5209, 'This looks like a good spot to find some ingredients', 4);
INSERT INTO Rating VALUES(5210, 'Bowser he means nothing to me', 3);

CREATE TABLE Is_Rated (
	ISBN VARCHAR(13),
	Book_Cond VARCHAR(10),
	Rate_ID INTEGER,
	FOREIGN KEY (ISBN, Book_Cond) REFERENCES Book(ISBN, Book_Cond) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Rate_ID) REFERENCES Rating(Rate_ID) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO Is_Rated VALUES( '1234455677', 'used', 5206);
INSERT INTO Is_Rated VALUES('1477325925', 'new', 5207);
INSERT INTO Is_Rated VALUES('8932578825', 'new', 5208);
INSERT INTO Is_Rated VALUES('8932578825', 'new', 5209);
INSERT INTO Is_Rated VALUES('1477325925', 'new', 5210);

CREATE TABLE Rates (
	RID INTEGER,
	Email VARCHAR(26),
	FOREIGN KEY (RID) REFERENCES Rating(Rate_ID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (Email) REFERENCES Customer(Email)
);
INSERT INTO Rates VALUES(5206, 'barney@gmail.com');
INSERT INTO Rates VALUES(5207, 'elmo@gmail.com');
INSERT INTO Rates VALUES(5208, 'larry_david@gmail.com');
INSERT INTO Rates VALUES(5209, 'elmo@gmail.com');
INSERT INTO Rates VALUES(5210, 'spongebob@gmail.com');

CREATE TABLE Shopping_Cart (
Cart_ID INTEGER PRIMARY KEY,
	Last_Updated DATE
);

INSERT INTO Shopping_Cart VALUES(1001, '2014-04-15');
INSERT INTO Shopping_Cart VALUES(1002, '2015-03-16');
INSERT INTO Shopping_Cart VALUES(1003, '2016-07-05');
INSERT INTO Shopping_Cart VALUES(1004, '2017-10-10');
INSERT INTO Shopping_Cart VALUES(1005, '2018-11-22');


CREATE TABLE In_Cart (
	Cart_ID INTEGER,
ISBN VARCHAR(20),
	Book_Cond VARCHAR(10),
FOREIGN KEY (ISBN, Book_Cond) REFERENCES Book(ISBN, Book_Cond) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (Cart_ID) REFERENCES Shopping_Cart(Cart_ID) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO In_Cart VALUES(1001, '1234455677', 'used');
INSERT INTO In_Cart VALUES(1001, '1477325925', 'new');
INSERT INTO In_Cart VALUES(1001, '8325787825', 'new');
INSERT INTO In_Cart VALUES(1001, '8932578825', 'new');
INSERT INTO In_Cart VALUES(1001, '3288324823', 'used');
INSERT INTO In_Cart VALUES(1001, '8437548384', 'used');
INSERT INTO In_Cart VALUES(1001, '574954985945', 'used');
INSERT INTO In_Cart VALUES(1002, '8325787825', 'new');
INSERT INTO In_Cart VALUES(1002, '8932578825', 'new');
INSERT INTO In_Cart VALUES(1003, '574954985945', 'used');
INSERT INTO In_Cart VALUES(1004, '1477325925', 'new');
INSERT INTO In_Cart VALUES(1004, '8325787825', 'new');
INSERT INTO In_Cart VALUES(1004, '8932578825', 'new');
INSERT INTO In_Cart VALUES(1005, '3288324823', 'used');


CREATE TABLE Has_Cart (
	Cart_ID INTEGER,
	Email VARCHAR(26),
	FOREIGN KEY (Cart_ID) REFERENCES Shopping_Cart(Cart_ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Email) REFERENCES User(Email) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Has_Cart VALUES(1001, 'barney@gmail.com');
INSERT INTO Has_Cart VALUES(1002, 'spongebob@gmail.com');
INSERT INTO Has_Cart VALUES(1003, 'jerry@gmail.com');
INSERT INTO Has_Cart VALUES(1004, 'imricherthanyou@rcn.com');
INSERT INTO Has_Cart VALUES(1005, 'tesla@gmail.com');