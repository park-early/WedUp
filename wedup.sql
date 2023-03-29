drop table GroomsMarry;
drop table BridesHolds;
drop table Bouquets;
drop table ParticipateIn;
drop table WorksAt;
drop table Attends;
drop table ForWho;
drop table WeddingsBookFor;
drop table Venues;
drop table Staff;
drop table PlusOnesBring;
drop table Entourages;
drop table Bakes;
drop table EntouragesAttire;
drop table VenuesProvince;
drop table StaffHourlyRate;
drop table Officiants;
drop table Caterers;
drop table Photographers;
drop table Cakes;
drop table Guests;


create table Bouquets(
BouquetType char(30) null,
primary key (BouquetType)
);

grant select on Bouquets to public;

create table BridesHolds(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
BouquetType char(30) null,
primary key (Email),
foreign key (BouquetType) references Bouquets
);

grant select on BridesHolds to public;

create table EntouragesAttire(
Role char(30) null ,
Attire char(30) null,
primary key (Role)
);

grant select on EntouragesAttire to public;

create table VenuesProvince(
PostalCode char(30) null,
Province char(30) null,
primary key (PostalCode)
);

grant select on VenuesProvince to public;

create table StaffHourlyRate(
Company char(30) null,
HourlyRate int null,
primary key (Company)
);

grant select on StaffHourlyRate to public;

create table Officiants(
Email char(30) null,
IsAPriest number(1) null,
primary key (Email)
);

grant select on Officiants to public;

create table Caterers(
Email char(30) null,
Cuisine char(30) null, 
primary key (Email)
);

grant select on Caterers to public;

create table Photographers(
Email char(30) null,
Camera char(30) null,
primary key (Email)
);

grant select on Photographers to public;

create table Cakes(
Flavour char(30) null,
NumberOfTiers int null,
primary key (Flavour, NumberOfTiers)
);

grant select on Cakes to public;

create table Guests(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email)
);

grant select on Guests to public;

create table Venues(
StreetAddress char(30) null,
Name char(30) null,
MaxCapacity int null,
PostalCode char(30) null,
primary key (StreetAddress),
foreign key (PostalCode) references VenuesProvince ON DELETE CASCADE
);

grant select on Venues to public;

create table Staff(
Email char(30) null,
Company char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email),
foreign key (Company) references StaffHourlyRate ON DELETE CASCADE
);

grant select on Staff to public;

create table Entourages(
Email char(30) null,
Role char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email),
foreign key (Role) references EntouragesAttire ON DELETE CASCADE
);

grant select on Entourages to public;


create table WeddingsBookFor(
WeddingNumber int null,
StreetAddress char(30) not null,
WeddingDate date null,
primary key (WeddingNumber),
foreign key (StreetAddress) references Venues ON DELETE CASCADE
);

grant select on WeddingsBookFor to public;


create table PlusOnesBring(
GuestEmail char(30) null,
PlusOneEmail char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (GuestEmail, PlusOneEmail),
foreign key (GuestEmail) references Guests
);

grant select on PlusOnesBring to public;

create table Bakes(
CatererEmail char(30) null,
Flavour char(30) null,
NumberOfTiers int null,
primary key (CatererEmail, Flavour, NumberOfTiers),
foreign key (CatererEmail) references Caterers,
foreign key (Flavour, NumberOfTiers) references Cakes
);

grant select on Bakes to public;

create table ForWho(
Flavour char(30) null,
NumberOfTiers int null,
WeddingNumber int null,
primary key (Flavour, NumberOfTiers, WeddingNumber),
foreign key (Flavour, NumberOfTiers) references Cakes,
foreign key (WeddingNumber) references WeddingsBookFor
);

grant select on ForWho to public;

create table Attends(
WeddingNumber int null,
GuestEmail char(30) null,
primary key (WeddingNumber, GuestEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (GuestEmail) references Guests
);

grant select on Attends to public;

create table WorksAt(
WeddingNumber int null,
StaffEmail char(30) null,
primary key (WeddingNumber, StaffEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (StaffEmail) references Staff
);

grant select on WorksAt to public;

create table ParticipateIn(
WeddingNumber int null,
EntourageEmail char(30) null,
primary key (WeddingNumber, EntourageEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (EntourageEmail) references Entourages
);

grant select on ParticipateIn to public;

create table GroomsMarry(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
BrideEmail char(30) not null unique,
WeddingNumber int not null unique,
primary key (Email),
foreign key (BrideEmail) references BridesHolds ON DELETE CASCADE,
foreign key (WeddingNumber) references WeddingsBookFor ON DELETE CASCADE
);

grant select on GroomsMarry to public;




insert into Bouquets
values('cascade');

insert into Bouquets
values('posy');

insert into Bouquets
values('hand-tied');

insert into Bouquets
values('round');

insert into Bouquets
values('pomander');

insert into Bouquets
values('composite'),

insert into Bouquets
values('nosegay');


insert into BridesHolds
values('ilsalund@gmail.com', 'Ilsa', 'Lund', 'cascade');

insert into BridesHolds
values('rosedewittbukater@gmail.com', 'Rose', 'DeWitt Bukater', 'posy');

insert into BridesHolds
values('miadolan@gmail.com', 'Amelia', 'Dolan', 'hand-tied');

insert into BridesHolds
values('jennycurran@gmail.com', 'Jenny', 'Curran', 'round');

insert into BridesHolds
values('elliedocter@gmail.com', 'Elizabeth', 'Docter', 'pomander');


insert into EntouragesAttire
values('best man', 'suit');

insert into EntouragesAttire
values('groomsman', 'suit');

insert into EntouragesAttire
values('bridesmaid', 'dress');

insert into EntouragesAttire
values('flower girl', 'dress');

insert into EntouragesAttire
values('usher', 'suit');

insert into EntouragesAttire
values('ring bearer', 'suit');


insert into VenuesProvince
values('V6B 3L4', 'BC');

insert into VenuesProvince
values('V6T 1Z2', 'BC');

insert into VenuesProvince
values('V6M 4H1', 'BC');

insert into VenuesProvince
values('V6G 3E2', 'BC');

insert into VenuesProvince
values('T1L 1J4', 'Alberta');


insert into StaffHourlyRate
values('Casablanca Co.', 30);

insert into StaffHourlyRate
values('Titanic Studio', 28);

insert into StaffHourlyRate
values('La La Land Ltd.', 22);

insert into StaffHourlyRate
values('Paramount', 20);

insert into StaffHourlyRate
values('Forrest Gump and Co.', 23);

insert into StaffHourlyRate
values('Up Services', 22);


insert into Officiants
values('michaelcurtiz@gmail.com', 1);

insert into Officiants
values('jamescameron@gmail.com', 0);

insert into Officiants
values('damienchazelle@gmail.com', 0);


insert into Caterers
values('maxsteiner@gmail.com', 'austrian');

insert into Caterers
values('jameshorner@gmail.com', 'dessert');

insert into Caterers
values('brianrobins@gmail.com', 'dessert');

insert into Caterers
values('johnlegend@gmail.com', 'american');


insert into Photographers
values('celinedion@gmail.com', 'canon');

insert into Photographers
values('petedocter@gmail.com', 'nikon');


insert into Cakes
values('tiramisu', 3);

insert into Cakes
values('tiramisu', 2);

insert into Cakes
values('red velvet', 7);

insert into Cakes
values('black forest', 4);

insert into Cakes
values('creme brulee', 1);


insert into Guests
values('signorferrari@gmail.com', 'Signor', 'Ferrari');

insert into Guests
values('brocklovett@gmail.com', 'Brock', 'Lovett');

insert into Guests
values('caledonhockley@gmail.com', 'Caledon', 'Hockley');

insert into Guests
values('captsmith@gmail.com', 'Edward John', 'Smith');

insert into Guests
values('amybrandt@gmail.com', 'Amy', 'Brandt');


insert into Venues
values('601 Smithe St', 'The Orpheum', 2780, 'V6B 3L4');

insert into Venues
values('6301 Crescent Rd', 'UBC Rose Garden', 250, 'V6T 1Z2');

insert into Venues
values('5251 Oak St', 'VanDusen Botanical Garden', 400, 'V6M 4H1');

insert into Venues
values('845 Avison Way', 'Vancouver Aquarium', 1000, 'V6G 3E2');

insert into Venues
values('405 Spray Ave', 'Fairmont Banff Springs', 2500, 'T1L 1J4');


insert into Staff
values('michaelcurtiz@gmail.com', 'Casablanca Co.', 'Michael', 'Curtiz');

insert into Staff
values('maxsteiner@gmail.com', 'Casablanca Co.', 'Max', 'Steiner');

insert into Staff
values('jamescameron@gmail.com', 'Titanic Studio', 'James', 'Cameron');

insert into Staff
values('jameshorner@gmail.com', 'Titanic Studio', 'James', 'Horner');

insert into Staff
values('celinedion@gmail.com', 'Titanic Studio', 'Celine', 'Dion');

insert into Staff
values('damienchazelle@gmail.com', 'La La Land Ltd.', 'Damien', 'Chazelle');

insert into Staff
values('johnlegend@gmail.com', 'La La Land Ltd.', 'John', 'Legend');

insert into Staff
values('brianrobins@gmail.com', 'Paramount', 'Brian', 'Robins');

insert into Staff
values('robertzemeckis@gmail.com', 'Forrest Gump and Co.', 'Robert', 'Zemeckis');

insert into Staff
values('petedocter@gmail.com', 'Up Services', 'Pete', 'Docter');


insert into Entourages
values('captrenault@gmail.com', 'best man', 'Louis', 'Renault');

insert into Entourages
values('victorlaszlo@gmail.com', 'usher', 'Victor', 'Laszlo');

insert into Entourages
values('ruthdewittbukater@gmail.com', 'bridesmaid', 'Ruth', 'DeWitt Bukater');

insert into Entourages
values('lizzyclavert@gmail.com', 'flower girl', 'Lizzy', 'Calvert');

insert into Entourages
values('tommyryan@gmail.com', 'best man', 'Tommy', 'Ryan');

insert into Entourages
values('laurawilder@gmail.com', 'bridesmaid', 'Laura', 'Wilder');

insert into Entourages
values('ltdan@gmail.com', 'best man', 'Dan', 'Taylor');

insert into Entourages
values('bubba@gmail.com', 'groomsman', 'Benjamin Buford', 'Blue');

insert into Entourages
values('charlesmuntz@gmail.com', 'usher', 'Charles', 'Muntz');

insert into Entourages
values('russelnagai@gmail.com', 'ring bearer', 'Russel', 'Nagai');


insert into WeddingsBookFor
values(1, '601 Smithe St', to_date('2023/08/23', 'yyyy/mm/dd'));

insert into WeddingsBookFor
values(2, '6301 Crescent Rd', to_date('2023/09/24', 'yyyy/mm/dd'));

insert into WeddingsBookFor
values(3,'5251 Oak St', to_date('2023/10/25', 'yyyy/mm/dd'));

insert into WeddingsBookFor
values(4, '845 Avison Way', to_date('2023/11/26', 'yyyy/mm/dd'));

insert into WeddingsBookFor
values(5, '405 Spray Ave', to_date('2023/12/27', 'yyyy/mm/dd'));


insert into PlusOnesBring
values('signorferrari@gmail.com', 'majstrasser@gmail.com', 'Heinrich', 'Strasser');

insert into PlusOnesBring
values('signorferrari@gmail.com', 'janbrandel@gmail.com', 'Jan', 'Brandel');

insert into PlusOnesBring
values('brocklovett@gmail.com', 'fabrizioderossi@gmail.com', 'Fabrizio', 'De Rossi');

insert into PlusOnesBring
values('caledonhockley@gmail.com', 'spicerlovejoy@gmail.com', 'Spicer', 'Lovejoy');

insert into PlusOnesBring
values('captsmith@gmail.com', 'archibaldgracie@gmail.com', 'Archibald', 'Gracie');


insert into Bakes
values('jameshorner@gmail.com', 'tiramisu', 3);

insert into Bakes
values('jameshorner@gmail.com', 'black forest', 4);

insert into Bakes
values('brianrobins@gmail.com', 'tiramisu', 2);

insert into Bakes
values('brianrobins@gmail.com', 'red velvet', 7);

insert into Bakes
values('brianrobins@gmail.com', 'creme brulee', 1);


insert into ForWho
values('tiramisu', 3, 1),

insert into ForWho
values('black forest', 4, 1),

insert into ForWho
values('tiramisu', 2, 4),

insert into ForWho
values('red velvet', 7, 3),

insert into ForWho
values('creme brulee', 1, 3);


insert into Attends
values(1, 'signorferrari@gmail.com');

insert into Attends
values(2, 'brocklovett@gmail.com');

insert into Attends
values(2, 'caledonhockley@gmail.com');

insert into Attends
values(2, 'captsmith@gmail.com');

insert into Attends
values(3, 'amybrandt@gmail.com');


insert into WorksAt
values(1, 'michaelcurtiz@gmail.com');

insert into WorksAt
values(1, 'maxsteiner@gmail.com');

insert into WorksAt
values(2, 'jamescameron@gmail.com');

insert into WorksAt
values(2, 'jameshorner@gmail.com');

insert into WorksAt
values(2, 'celinedion@gmail.com');

insert into WorksAt
values(3, 'damienchazelle@gmail.com');

insert into WorksAt
values(3, 'johnlegend@gmail.com');

insert into WorksAt
values(3, 'brianrobins@gmail.com');

insert into WorksAt
values(4, 'brianrobins@gmail.com');

insert into WorksAt
values(4, 'robertzemeckis@gmail.com');

insert into WorksAt
values(5, 'petedocter@gmail.com');


insert into ParticipateIn
values(1, 'captrenault@gmail.com');

insert into ParticipateIn
values(1, 'victorlaszlo@gmail.com');

insert into ParticipateIn
values(2, 'ruthdewittbukater@gmail.com');

insert into ParticipateIn
values(2, 'lizzyclavert@gmail.com');

insert into ParticipateIn
values(2, 'tommyryan@gmail.com');

insert into ParticipateIn
values(3, 'laurawilder@gmail.com');

insert into ParticipateIn
values(4, 'ltdan@gmail.com');

insert into ParticipateIn
values(4, 'bubba@gmail.com');

insert into ParticipateIn
values(5, 'charlesmuntz@gmail.com');

insert into ParticipateIn
values(5, 'russelnagai@gmail.com');


insert into GroomsMarry
values('rickblaine@gmail.com', 'Rick', 'Blaine', 'ilsalund@gmail.com', 1);

insert into GroomsMarry
values('jackdawson@gmail.com', 'Jack', 'Dawson', 'rosedewittbukater@gmail.com', 2);

insert into GroomsMarry
values('sebwilder@gmail.com', 'Sebastian', 'Wilder', 'miadolan@gmail.com', 3);

insert into GroomsMarry
values('forrestgump@gmail.com', 'Forrest', 'Gump', 'jennycurran@gmail.com', 4);

insert into GroomsMarry
values('carlfredrickson@gmail.com', 'Carl', 'Fredrickson', 'elliedocter@gmail.com', 5);

