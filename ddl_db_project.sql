CREATE TABLE hotel_chain (
	hq_address varchar (50) PRIMARY KEY NOT NULL,
	num_of_hotels  integer ,
	email varchar (50),
	phone_number varchar(20),
	hotel_chain_name varchar(50)
);


CREATE TABLE hotel (
	hotel_id integer NOT NULL UNIQUE,
	hq_address varchar(50) NOT NULL,
	PRIMARY KEY (hotel_id, hq_address),
	stars integer,
	num_of_rooms integer,
	hotel_email varchar(50),
	hotel_phone_number varchar(20),
	city varchar(20),
	street varchar(20),
	postal_code varchar(20),
	UNIQUE(city, street, postal_code),
	FOREIGN KEY (hq_address) REFERENCES hotel_chain(hq_address)
);


CREATE TABLE customer (
	customer_id integer PRIMARY KEY NOT NULL,
	customer_SSN integer NOT NULL UNIQUE,
	customer_name varchar(50),
	customer_address varchar(50),
	registration_date varchar(50)
);

CREATE TABLE employee (
employee_id integer PRIMARY KEY NOT NULL,
hotel_id integer UNIQUE,
employee_name varchar(50),
employee_address varchar(50),
employee_SSN integer UNIQUE,
position varchar(50),
FOREIGN KEY (hotel_id) REFERENCES hotel(hotel_id)
);


CREATE TABLE room (
room_number integer NOT NULL,
hotel_id integer,
PRIMARY KEY(room_number, hotel_id),
customer_id integer,
price integer,
amenities varchar(50),
capacity varchar(50),
views varchar(50),
extension varchar(50),
booked varchar(50) NOT NULL,	
damages varchar(50),
FOREIGN KEY (hotel_id) REFERENCES hotel(hotel_id),
FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE rent (
    hotel_id integer NOT NULL,
    customer_id integer NOT NULL,
    room_number integer NOT NULL,
    PRIMARY KEY (hotel_id, customer_id, room_number),
    cc_info varchar(50),
    start_date varchar(20),
    end_date varchar(20),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (room_number, hotel_id) REFERENCES room(room_number, hotel_id)
);


-- constraints

ALTER TABLE employee
ADD CONSTRAINT employee_num_constraint
CHECK (employee_id BETWEEN 100000000 AND 999999999 AND employee_SSN BETWEEN 100000000 AND 999999999);


ALTER TABLE customer
ADD CONSTRAINT customer_num_constraint
CHECK (customer_id BETWEEN 100000000 AND 999999999 AND customer_SSN BETWEEN 100000000 AND 999999999);


ALTER TABLE hotel
ADD CONSTRAINT hotel_num_constraint
CHECK (hotel_id BETWEEN 1000 AND 999999999);

ALTER TABLE hotel
ADD CONSTRAINT star_constraint
CHECK (stars BETWEEN 1 AND 5);


-- ALTER TABLE room
-- ADD CONSTRAINT amenity_constraint
-- CHECK (amenities IN ('television', 'air_conditioner', 'fridge', 'microwave', 'oven', 'dishwasher', 'laundry'));
-- ALTER TABLE room
-- DROP CONSTRAINT amenity_constraint2; 

ALTER TABLE room
ADD CONSTRAINT amenity_constraint
CHECK (
	amenities = 'television' OR
	amenities = 'air_conditioner' OR
	amenities = 'fridge' OR
	amenities = 'fridge, television, air_conditioner' OR
	amenities = 'fridge, air_conditioner, television' OR
	amenities = 'fridge, television' OR
	amenities = 'fridge, air_conditioner' OR
	amenities = 'television, fridge, air_conditioner' OR
	amenities = 'television, air_conditioner, fridge' OR
	amenities = 'television, fridge' OR
	amenities = 'television, air_conditioner' OR
	amenities = 'air_conditioner, television, fridge' OR
	amenities = 'air_conditioner, fridge, television' OR
	amenities = 'air_conditioner, fridge' OR
	amenities = 'air_conditioner, television' 
);



ALTER TABLE room
ADD CONSTRAINT view_constraint
CHECK (capacity = 'single' OR capacity = 'double');

ALTER TABLE room
ADD CONSTRAINT extension_constraint
CHECK (views IN ('sea_view', 'mountain_view', 'city_view'));

ALTER TABLE room
ADD CONSTRAINT occupied_constraint
CHECK (booked = 'occupied' OR booked = 'empty'OR booked='booked');

ALTER TABLE employee
ADD CONSTRAINT employee_constraint
CHECK (position IN ('manager', 'cleaner', 'front_desk', 'cook', 'repair_man', 'gardener'));

-- insertions hotel_chain

INSERT INTO hotel_chain
VALUES ('4321 Blueberry Blvd, Greensville, CA', 8, 'deluxestay123@gmail.com', '987-109-5163', 'DeluxyStay Suites');

INSERT INTO hotel_chain
VALUES ('2468 Parkview Rd, Redwood City, NZ', 8, 'scaperesortscity929@gmail.com', '128-947-5033', 'CityScape Resorts');

INSERT INTO hotel_chain
VALUES ('3210 Lakeshore Rd, Seaside, DE', 8, 'sleeping4lodgersELITE@gmail.com', '876-351-0292', 'EliteSleep Lodging');

INSERT INTO hotel_chain
VALUES ('9876 Country Lane, Pineville, IT', 8, 'orangeWaveHotels8919@gmail.com', '947-120-8359', 'OrangeWave Hotels');

INSERT INTO hotel_chain
VALUES ('8642 Northfield Ave, Meadowbrook, JP', 8, 'riseandshinesuites8642@gmail.com', '734-902-6813', 'Sunrise Suites');


-- insertion hotels

INSERT INTO hotel VALUES (234567890, '9876 Country Lane, Pineville, IT', 1, 5, '234567890@gmail.com', '456-123-789', 'Cherrywood', '789 Oak Avenue', 'L5N 8C9');

INSERT INTO hotel VALUES (234567110, '9876 Country Lane, Pineville, IT', 1, 5, '234567450@gmail.com', '456-113-789', 'Cherrywood', '780 Oak Avenue', 'L5N 8D9');

-- The above 2 hotel insertions are located in the same area, Cherrywood

INSERT INTO hotel VALUES (36985117, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '52147@gmail.com', '123-456-700', 'Spring', '789 Ayrup Street', 'M2J 1P3');

INSERT INTO hotel
VALUES (678943215, '4321 Blueberry Blvd, Greensville, CA', 4, 5, '678943215deluxestay@gmail.com', '237-409-581', 'Rosedale', '10 Sycamore Drive', 'M3J 1P3');

INSERT INTO hotel
VALUES (357910111, '3210 Lakeshore Rd, Seaside, DE', 2, 5, '357910111@gmail.com', '246-801-357', 'Westonville', '456 Maple Drive', 'L4T 1K3');

INSERT INTO hotel VALUES (654789123, '8642 Northfield Ave, Meadowbrook, JP', 4, 5, '654789123@gmail.com', '369-852-147', 'Oakdale', '789 Cherry Lane', 'G1K 1A1');

INSERT INTO hotel VALUES (159753246, '4321 Blueberry Blvd, Greensville, CA', 5, 5, '159753246@gmail.com', '753-951-456', 'Lakewood Hills', '147 Pine Street', 'H3H 2A7');

INSERT INTO hotel VALUES (987654321, '9876 Country Lane, Pineville, IT', 1, 5, '987654321@gmail.com', '258-147-369', 'Havenview', '369 Willow Road', 'E1C 1B4');

INSERT INTO hotel VALUES (369852147, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '369852147@gmail.com', '123-456-789', 'Springwood', '789 Maple Street', 'M3J 1P3');

INSERT INTO hotel VALUES (258741369, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '258741369@gmail.com', '555-555-555', 'Glenwood', '369 Sycamore Lane', 'L5N 8C9');

INSERT INTO hotel VALUES (987654121, '4321 Blueberry Blvd, Greensville, CA', 2, 5, '987654321@gmail.com', '987-654-321', 'Willowdale', '456 Birch Road', 'K1Y 0C2');

INSERT INTO hotel VALUES (741852963, '9876 Country Lane, Pineville, IT', 3, 5, '741852963@gmail.com', '456-789-123', 'Roseville', '789 Cherry Lane', 'R3T 2N2');

INSERT INTO hotel VALUES (852369741, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '852369741@gmail.com', '321-654-987', 'Windsorville', '123 Elm Street', 'G1K 1A1');

INSERT INTO hotel VALUES (123789456, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '123789456@gmail.com', '555-123-456', 'Pinehurst', '789 Oak Avenue', 'E1C 1B4');

INSERT INTO hotel VALUES (456852963, '8642 Northfield Ave, Meadowbrook, JP', 3, 5, '456852963@gmail.com', '789-321-654', 'Oakdale', '456 Pine Street', 'G1K 1P3');

INSERT INTO hotel VALUES (369258147, '9876 Country Lane, Pineville, IT', 2, 5, '369258147@gmail.com', '987-321-654', 'Mapleview', '789 Cherry Lane', 'L5N 8C9');

INSERT INTO hotel VALUES (741369852, '4321 Blueberry Blvd, Greensville, CA', 1, 5, '741369852@gmail.com', '369-987-654', 'Glenhaven', '123 Cedar Lane', 'V6B 1M2');

INSERT INTO hotel VALUES (951753684, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '951753684@gmail.com', '654-321-987', 'Cedarhurst', '456 Sycamore Drive', 'H3H 2A7');

INSERT INTO hotel VALUES (258741963, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '258741963@gmail.com', '789-654-321', 'Parkville', '789 Birch Road', 'K1Y 0C2');

INSERT INTO hotel VALUES (123456987, '8642 Northfield Ave, Meadowbrook, JP', 3, 5, '123456987@gmail.com', '321-987-654', 'Willowview', '123 Pine Street', 'R3T 2N2');

INSERT INTO hotel VALUES (456789321, '4321 Blueberry Blvd, Greensville, CA', 2, 5, '456789321@gmail.com', '987-654-321', 'Cedarview', '456 Maple Drive', 'L4T 1K3');

INSERT INTO hotel VALUES (987654123, '9876 Country Lane, Pineville, IT', 1, 5, '987654123@gmail.com', '456-123-789', 'Cherrydale', '789 Oak Avenue', 'E1C 1B4');

INSERT INTO hotel VALUES (753159486, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '753159486@gmail.com', '987-123-456', 'Maplewood Heights', '123 Elm Street', 'H3H 2A7');

INSERT INTO hotel VALUES (963258741, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '963258741@gmail.com', '123-987-654', 'Cedarwood Park', '789 Oak Avenue', 'L4T 1K3');

INSERT INTO hotel VALUES (3698147, '8642 Northfield Ave, Meadowbrook, JP', 3, 5, '369852147@gmail.com', '456-321-987', 'Elmwood Heights', '456 Pine Street', 'N9B 4M2');

INSERT INTO hotel VALUES (951753258, '9876 Country Lane, Pineville, IT', 2, 5, '951753258@gmail.com', '789-654-321', 'Oakwood Heights', '789 Cherry Lane', 'M3J 1P3');

INSERT INTO hotel VALUES (456123789, '4321 Blueberry Blvd, Greensville, CA', 1, 5, '456123789@gmail.com', '321-654-987', 'Pine Grove Heights', '123 Cedar Lane', 'K1Y 0C2');

INSERT INTO hotel VALUES (258369147, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '258369147@gmail.com', '789-321-654', 'Willowwood Heights', '456 Sycamore Drive', 'L5N 8C9');

INSERT INTO hotel VALUES (852741963, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '852741963@gmail.com', '654-321-987', 'Glenwood Heights', '789 Birch Road', 'G1K 1A1');

INSERT INTO hotel VALUES (753951684, '8642 Northfield Ave, Meadowbrook, JP', 3, 5, '753951684@gmail.com', '987-654-321', 'Pineview Heights', '123 Pine Street', 'R3T 2N2');

INSERT INTO hotel VALUES (159357486, '4321 Blueberry Blvd, Greensville, CA', 2, 5, '159357486@gmail.com', '456-123-789', 'Cedar Grove Heights', '456 Maple Drive', 'E1C 1B4');

INSERT INTO hotel VALUES (9874321, '9876 Country Lane, Pineville, IT', 1, 5, '987654321@gmail.com', '789-456-123', 'Cherrywood Heights', '789 Oak Avenue', 'K1Y 4M2');

INSERT INTO hotel VALUES (123456789, '4321 Blueberry Blvd, Greensville, CA', 5, 5, '123456789@gmail.com', '321-654-987', 'Evergreen', '123 Maple Street', 'L2R 6P9');

INSERT INTO hotel VALUES (234567891, '2468 Parkview Rd, Redwood City, NZ', 4, 5, '234567891@gmail.com', '555-123-456', 'Briarwood', '789 Oak Avenue', 'T2P 2L7');

INSERT INTO hotel VALUES (345678912, '3210 Lakeshore Rd, Seaside, DE', 3, 5, '345678912@gmail.com', '237-409-581', 'Greenwood', '456 Pine Street', 'V1Y 3B7');

INSERT INTO hotel VALUES (456789123, '9876 Country Lane, Pineville, IT', 2, 5, '456789123@gmail.com', '789-654-321', 'Maplewood', '789 Cherry Lane', 'E1C 1B4');

INSERT INTO hotel VALUES (567891234, '8642 Northfield Ave, Meadowbrook, JP', 1, 5, '567891234@gmail.com', '369-987-654', 'Pinehurst', '123 Cedar Lane', 'K1Y 0C2');

INSERT INTO hotel VALUES (678912345, '2468 Parkview Rd, Redwood City, NZ', 5, 5, '678912345@gmail.com', '654-321-987', 'Willowdale', '456 Sycamore Drive', 'H3H 2A7');

INSERT INTO hotel VALUES (789123456, '3210 Lakeshore Rd, Seaside, DE', 4, 5, '789123456@gmail.com', '789-321-654', 'Glenwood', '789 Birch Road', 'M3J 1P3');

INSERT INTO hotel VALUES (891234567, '8642 Northfield Ave, Meadowbrook, JP', 3, 5, '891234567@gmail.com', '321-987-654', 'Cedarwood', '123 Pine Street', 'E1C 1B4');

INSERT INTO hotel VALUES (912345678, '4321 Blueberry Blvd, Greensville, CA', 2, 5, '912345678@gmail.com', '987-654-321', 'Pineview', '456 Maple Drive', 'V6B 4M2');


-- insert rooms


-- insert rooms

INSERT INTO room VALUES (1, 678943215, null, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 678943215, null, 150, 'air_conditioner', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 678943215, null, 200, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 678943215, null, 300, 'fridge', 'double', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 678943215, null, 400, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 357910111, null, 150, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 357910111, null, 200, 'air_conditioner', 'double', 'city_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 357910111, null, 250, 'television, air_conditioner', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 357910111, null, 350, 'fridge', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 357910111, null, 450, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 654789123, NULL, 100, 'television, air_conditioner', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 654789123, NULL, 200, 'fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 654789123, NULL, 300, 'fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 654789123, NULL, 400, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 654789123, NULL, 500, 'fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 159753246, NULL, 100, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 159753246, NULL, 200, 'fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 159753246, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 159753246, NULL, 400, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 159753246, NULL, 500, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 987654321, NULL, 100, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 987654321, NULL, 200, 'fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 987654321, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 987654321, NULL, 400, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 987654321, NULL, 500, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 369852147, NULL, 100, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 369852147, NULL, 200, 'fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 369852147, NULL, 300, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 369852147, NULL, 400, 'fridge', 'double', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 369852147, NULL, 500, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 258741369, NULL, 100, 'television, fridge', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 258741369, NULL, 200, 'air_conditioner', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 258741369, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 258741369, NULL, 400, 'fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 258741369, NULL, 500, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 987654121, NULL, 100, 'television, fridge', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 987654121, NULL, 200, 'air_conditioner', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 987654121, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 987654121, NULL, 400, 'fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 987654121, NULL, 500, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 741852963, NULL, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 741852963, NULL, 200, 'fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 741852963, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 741852963, NULL, 400, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 741852963, NULL, 500, 'air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 852369741, NULL, 150, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 852369741, NULL, 300, 'television', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 852369741, NULL, 350, 'television, fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 852369741, NULL, 400, 'television, air_conditioner, fridge', 'double', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 852369741, NULL, 450, 'television, air_conditioner', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 123789456, NULL, 150, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 123789456, NULL, 200, 'television', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 123789456, NULL, 250, 'television, air_conditioner', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 123789456, NULL, 300, 'fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 123789456, NULL, 350, 'television, air_conditioner, fridge', 'double', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 456852963, NULL, 300, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 456852963, NULL, 400, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 456852963, NULL, 250, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 456852963, NULL, 450, 'television, air_conditioner, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 456852963, NULL, 200, 'television, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (1, 369258147, NULL, 300, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (2, 369258147, NULL, 400, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room
VALUES (3, 369258147, NULL, 250, 'television, air_conditioner', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (4, 369258147, NULL, 450, 'television, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room
VALUES (5, 369258147, NULL, 200, 'television, air_conditioner', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 741369852, NULL, 100, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 741369852, NULL, 250, 'fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 741369852, NULL, 350, 'television, fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 741369852, NULL, 400, 'television, air_conditioner', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 741369852, NULL, 450, 'air_conditioner, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 951753684, NULL, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 951753684, NULL, 200, 'television', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 951753684, NULL, 300, 'air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 951753684, NULL, 400, 'television', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 951753684, NULL, 500, 'fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 258741963, NULL, 200, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 258741963, NULL, 250, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 258741963, NULL, 400, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 258741963, NULL, 300, 'television, air_conditioner', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 258741963, NULL, 150, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (1, 123456987, NULL, 150, 'television, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room
VALUES (2, 123456987, NULL, 250, 'air_conditioner', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (3, 123456987, NULL, 200, 'television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room
VALUES (4, 123456987, NULL, 300, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room
VALUES (5, 123456987, NULL, 400, 'fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 456789321, NULL, 150, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 456789321, NULL, 250, 'television, fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 456789321, NULL, 400, 'television, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 456789321, NULL, 300, 'air_conditioner, fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 456789321, NULL, 200, 'television, air_conditioner, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 987654123, null, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (2, 987654123, null, 150, 'fridge', 'double', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (3, 987654123, null, 200, 'television', 'single', 'city_view', 'no', 'empty', null);

INSERT INTO room VALUES (4, 987654123, null, 250, 'fridge', 'double', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (5, 987654123, null, 300, 'fridge', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (1, 753159486, NULL, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 753159486, NULL, 300, 'television', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 753159486, NULL, 200, 'television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 753159486, NULL, 350, 'television', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 753159486, NULL, 400, 'air_conditioner', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 963258741, NULL, 250, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 963258741, NULL, 200, 'air_conditioner', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 963258741, NULL, 400, 'television, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 963258741, NULL, 300, 'television, air_conditioner', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 963258741, NULL, 150, 'fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 3698147, NULL, 200, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 3698147, NULL, 350, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 3698147, NULL, 400, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 3698147, NULL, 250, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 3698147, NULL, 300, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 951753258, null, 150, 'fridge', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 951753258, null, 200, 'fridge', 'single', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 951753258, null, 250, 'fridge', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 951753258, null, 300, 'fridge', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 951753258, null, 350, 'fridge', 'double', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 456123789, NULL, 150, 'fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 456123789, NULL, 200, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 456123789, NULL, 300, 'fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 456123789, NULL, 400, 'television, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 456123789, NULL, 450, 'air_conditioner', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 258369147, null, 200, 'air_conditioner, television, fridge', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (2, 258369147, null, 150, 'television, fridge', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (3, 258369147, null, 400, 'air_conditioner, television, fridge', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (4, 258369147, null, 250, 'air_conditioner, television', 'single', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (5, 258369147, null, 300, 'television', 'double', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (1, 852741963, NULL, 200, 'fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 852741963, NULL, 250, 'television, air_conditioner', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 852741963, NULL, 300, 'fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 852741963, NULL, 350, 'fridge', 'double', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 852741963, NULL, 400, 'air_conditioner', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 753951684, NULL, 150, 'television, air_conditioner, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 753951684, NULL, 250, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 753951684, NULL, 350, 'television, air_conditioner, fridge', 'double', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 753951684, NULL, 450, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 753951684, NULL, 500, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 159357486, null, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 159357486, null, 150, 'fridge', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 159357486, null, 250, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 159357486, null, 300, 'television, fridge', 'single', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 159357486, null, 500, 'television, air_conditioner, fridge', 'double', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 9874321, NULL, 100, 'fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 9874321, NULL, 250, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 9874321, NULL, 400, 'fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 9874321, NULL, 450, 'fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 9874321, NULL, 500, 'fridge', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 123456789, NULL, 150, 'television, air_conditioner, fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 123456789, NULL, 250, 'air_conditioner', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 123456789, NULL, 200, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 123456789, NULL, 350, 'television, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 123456789, NULL, 400, 'television, air_conditioner', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 234567891, NULL, 200, 'fridge', 'single', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 234567891, NULL, 400, 'air_conditioner', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 234567891, NULL, 150, 'television', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 234567891, NULL, 300, 'fridge', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 234567891, NULL, 250, 'fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 345678912, NULL, 150, 'television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (2, 345678912, NULL, 250, 'television, air_conditioner', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (3, 345678912, NULL, 350, 'television, air_conditioner, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (4, 345678912, NULL, 400, 'television, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 345678912, NULL, 450, 'television, air_conditioner, fridge', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 456789123, null, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 456789123, null, 150, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 456789123, null, 200, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 456789123, null, 250, 'television, air_conditioner, fridge', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 456789123, null, 300, 'television, air_conditioner', 'single', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 567891234, NULL, 200, 'television, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 567891234, NULL, 250, 'television', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 567891234, NULL, 400, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 567891234, NULL, 350, 'television, air_conditioner', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (5, 567891234, NULL, 100, 'television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (1, 678912345, null, 100, 'fridge', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (2, 678912345, null, 200, 'fridge', 'double', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (3, 678912345, null, 300, 'fridge', 'single', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 678912345, null, 350, 'television, fridge', 'double', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 678912345, null, 400, 'television, fridge', 'single', 'mountain_view', 'yes', 'empty',null);

INSERT INTO room VALUES (1, 789123456, null, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 789123456, null, 150, 'television, fridge, air_conditioner', 'single', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 789123456, null, 200, 'television, fridge, air_conditioner', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 789123456, null, 250, 'television, fridge, air_conditioner', 'single', 'sea_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 789123456, null, 300, 'television, fridge, air_conditioner', 'double', 'mountain_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 891234567, null, 150,  'television, fridge, air_conditioner', 'single', 'sea_view', 'yes', 'empty', null);

INSERT INTO room VALUES (2, 891234567, null, 200,  'television, fridge, air_conditioner', 'double', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (3, 891234567, null, 250, 'fridge, air_conditioner', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (4, 891234567, null, 300, 'television, fridge, air_conditioner', 'single', 'mountain_view', 'no', 'empty', null);

INSERT INTO room VALUES (5, 891234567, null, 350, 'television, fridge, air_conditioner', 'double', 'city_view', 'yes', 'empty', null);

INSERT INTO room VALUES (1, 912345678, NULL, 300, 'air_conditioner, television', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 912345678, NULL, 250, 'television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 912345678, NULL, 200, 'fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 912345678, NULL, 150, 'air_conditioner, television, fridge', 'single', 'city_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 912345678, NULL, 350, 'air_conditioner, television', 'double', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 234567890, NULL, 100, 'fridge', 'single' , 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 234567890, NULL, 200, 'air_conditioner', 'double', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 234567890, NULL, 250, 'fridge', 'double', 'mountain_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 234567890, NULL, 350, 'fridge', 'single', 'sea_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 234567890, NULL, 400, 'fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 36985117, NULL, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 36985117, NULL, 150, 'television, air_conditioner', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 36985117, NULL, 200, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 36985117, NULL, 250, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 36985117, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (1, 234567110, NULL, 100, 'television, air_conditioner, fridge', 'single', 'sea_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (2, 234567110, NULL, 150, 'television, air_conditioner', 'double', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (3, 234567110, NULL, 200, 'television, air_conditioner, fridge', 'double', 'city_view', 'yes', 'empty', NULL);

INSERT INTO room VALUES (4, 234567110, NULL, 250, 'television, air_conditioner, fridge', 'single', 'mountain_view', 'no', 'empty', NULL);

INSERT INTO room VALUES (5, 234567110, NULL, 300, 'television, air_conditioner, fridge', 'single', 'city_view', 'yes', 'empty', NULL);



-- insert into employees
INSERT INTO employee VALUES (111111111, 987654123, 'Aleckson Townsend', '3 Texas Turkey Road', 679976769, 'gardener');

INSERT INTO employee VALUES (123456789, 987654321, 'Tommy Green', '1 Green Grassway', 736145820, 'front_desk');

INSERT INTO employee VALUES (222222222, 852369741, 'Payal Patel', '39 Envy Road', 987654321, 'front_desk');

INSERT INTO employee VALUES (444444444, 234567890, 'Mohammed Klink', '790 Parksway Road', 432187659, 'front_desk');

INSERT INTO employee VALUES (333333333, 987654121, 'Morgan Smith', '600 Poppy Paveway', 546718888, 'gardener');
INSERT INTO employee VALUES (666666666, 357910111, 'Vicky Patel', '10 Chenuo Way', '978123470', 'cleaner');
INSERT INTO employee VALUES (777777777, 741369852, 'Wassim Ahmar', '15 Roadstrike Way', '978123333', 'cook');
INSERT INTO employee VALUES (888888888, 951753258, 'Theo James', '100 Pizza Way', '597851234', 'manager');
INSERT INTO employee VALUES (999999999, 654789123, 'Von Right', '300 Bread And Milk Street', '978124444', 'manager');
INSERT INTO employee VALUES (999666999, 159753246, 'Vikas Dune', '109 Cheshire Way', '879908484', 'front_desk');

INSERT INTO employee VALUES (909109381, 789123456, 'Rex Grimes', '10 Clyde Way', '978123471', 'cleaner');
INSERT INTO employee VALUES (183901909, 741852963, 'John Stone', '29 Bakery Way', '978123565', 'cook');
INSERT INTO employee VALUES (647524689, 123789456, 'James King', '339 King Klyde', '978129091', 'manager');
INSERT INTO employee VALUES (909890689, 258741963, 'Yope Mare', '109 Eggstone Way', '879901609', 'manager');

CREATE FUNCTION hq_checker() 
RETURNS TRIGGER AS $$
BEGIN
    IF NOT EXISTS (SELECT * FROM hotel_chain WHERE hq_address = NEW.hq_address) THEN
        RAISE EXCEPTION 'INVALID HQ ADDRESS';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_hq 
BEFORE INSERT ON hotel 
FOR EACH ROW 
EXECUTE FUNCTION hq_checker();

-- EMPLOYEE AND HOTEL ID
-- DROP TRIGGER check_employee ON employee;

CREATE FUNCTION delete_workers() 
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT * FROM employee WHERE hotel_id = NEW.hotel_id) THEN
        DELETE FROM employee WHERE hotel_id = NEW.hotel_id; 
        RAISE NOTICE 'EMPLOYEE DELETE FROM EMPLOYEE TABLE';
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_employee 
AFTER DELETE ON hotel
FOR EACH ROW 
EXECUTE FUNCTION delete_workers();

-- HOTEL ID AND ROOM
CREATE FUNCTION delete_housing() 
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT * FROM room WHERE hotel_id = NEW.hotel_id) THEN
        DELETE FROM room WHERE hotel_id = NEW.hotel_id; 
        RAISE NOTICE 'ROOM DELETED FROM ROOM TABLE';
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_room 
AFTER DELETE ON hotel
FOR EACH ROW 
EXECUTE FUNCTION delete_housing();

-- CUSTOMER AND ROOM
CREATE FUNCTION update_housing() 
RETURNS TRIGGER AS $$
BEGIN
    IF NOT EXISTS (SELECT * FROM customer WHERE customer_id = NEW.customer_id) THEN
        RAISE EXCEPTION 'INVALID CUSTOMER ID. CANNOT UPDATE ROOM.';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_room
BEFORE UPDATE ON room
FOR EACH ROW 
EXECUTE FUNCTION update_housing();



SELECT * FROM room WHERE price > 250;

SELECT * FROM room WHERE views = 'mountain_view';

SELECT * FROM hotel WHERE stars = 5;

SELECT * FROM Room WHERE extension = 'yes';

CREATE INDEX index_room_amenities ON room (amenities); 

CREATE INDEX index_room_view ON room (views); 

CREATE INDEX index_room_avalibility ON room (booked);




