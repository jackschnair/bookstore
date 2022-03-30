Readme

Query 1
-A customer can register on the registry page.  Once the registration is complete, they may login in with their email (which acts as a primary
key).  By selecting the Membership Settings page, a customer can upgrade to become a member.  In order to do so, they must enter their payment 
information.  Also, on the membership settings page has the ability for members to terminate their membership.

Query 2
-A publisher can log in using the publisher login page.  Once logged in, publishers can click on the add new book or change price page to
add a new book to the bookstore or change the price of an existing book that they have published.  Note that by adding a new book, a used version of the book is 
automatically added to the bookstore at a discounted price, and a trade value is generated for that book which
is a fraction of the price (unless the book is digital in which case there is no trade value or used variant).  By updating the price, 
the system will also update the price of the used copy and the trade value of the book. The publisher may not control the price of the used book
or the trade value.  The publisher also has no control over shipping cost which is by default 3.99.  Another important note is that the author must
be in our database system.  Publishers and the super user can add authors on the "Add Author" page.

Query 3
-The super user can log in on the user login page by entering in "SPECIAL" for an email and "securepassword" as the password.  They can see most of
the pages that a typical user can see (excluding the special page for authors to view their books) plus some extras.  In the case of query 3, the super
user can click on the update shipping cost page.  They can then fill out a short form to update the shipping cost of a book. Note that members always receive
free shipping and the super user is unable to change this.
-The super user cannot trade in books.


Query 4
-There are a few different ways a customer can search for a book.  They can either search with a keyword on the Book Search page or the may view a list
of all the books on the View Books page.  On the Book Search page customers may enter the title, author, genre, or ISBN of the book.  Once entered,
all the books that fit the search criteria will be listed.  The title and author don't need to be exact matches for a book to be found, but the genre and ISBN do.  Once one
finds the book they are looking for, they may add it to their cart by clicking add to cart. 
-For guests the process is slightly different.  Each guest must be given a shopping cart before they can add to cart.  In order to do so, each guest must
give the bookstore some information.  Hence, if the guest does not have a shopping cart, they will be redirected to a page where they can fill out 
information, so that one can be given to them.  However, guests may still view all the books without having to enter in any information (they just can't
add them to their cart).
-Purchasing books functions the same way for guests and registered users.  Each user must go to their shopping cart.  There, they can edit their cart by
removing books if they'd like.  Once done, they can hit purchase where they will then be prompted to fill out credit card information and to give the store
an address to ship to.  They then click purchase completing the purchase.  For shipping costs, paying members will receive free, express shipping while all
other users receive standard shipping and a fee.  The exception is for digital books which always have free shipping.  When purchasing
books store credit will be deducted and used towards payments if the user has any (for registered users only).  Behind the scenes the payment information is recorded in the database, 
an order is created, and the books that were ordered are recorded.  The shopping cart is also emptied.

Query 5
-Available on the best-sellers page. Registered users and guests may search for the best-selling book of a particular year in a similar fashion to the
book search page.  If the user does not enter a year, the best-selling book on the site will be shown.  If there is no best-selling book for that year,
no books will be listed.  If there is a tie both books will be listed. Book sales are counted by ISBN meaning that the sales of new and used books are combined when determining a best-seller.
This is in contrast to the analytics page which separates used and new books.

Query 6
-Customers can view their order history by viewing the order history page.  Guests must enter their order number (given to them
at checkout) to see the list of books that they ordered.  Registered customers can see all of their orders automatically.  Both have the option to 
add previously purchased books to their cart again.  Guests may not leave a rating, but registered users can click the leave a rating button on this page to do so. 

Query 7
-By logging in as an author, you will have access to a special page that lists all the books that author has written called "Your Books".  It
functions in a similar way to the search book page in that you have option to add books to cart.  A registered user can become an author when some publisher
or the super user creates an author with their email on the "Add Author" page.

Query 8
-By going to the order history page, registered users can leave reviews on books they have purchased. Reviews can be read by other users by clicking
the view ratings button on the search book and view books pages. One review is allowed per book per registered user.

Extra Features

-By logging in as a publisher you can go to an analytics page.  This page will give you information about how well your books have sold 
including how many units have been sold, how much money each book has generated and how many wish lists your book is on.

-Wish lists are like shopping carts except they are public.  You can add books to your wish list by clicking the add to wish list button on the Book Search or
View Books page.  You can then view your own wish list or go to the Search for a Wish List page to view someone else's.  You can use someone else's wish list
to get gift ideas for them if you'd like or suggestions for yourself.  While viewing wish lists that belong to other people you may add books to your cart or
wish list.  While viewing your own wish list you may books to cart or remove books from your list. Wish lists are available only for registered users.

-The most complex special feature is the ability to trade books in.  In this way, the bookstore would be able to sell used books traded in
by customers in a fashion similar to that of GameStop.  A user who is logged in can elect to trade in a book by clicking the trade button
available on the View Books page or in the Book Search page.  The user will then be prompted to send the book to a certain location.  Once 
the bookstore has received the book, a moderator (in this case the super user) can log in and fill out a short form specifying that the book has
been successfully traded in (this small form is called the "Update Trade" form).  When finished the database will update to record that the book
was successfully traded in, increasing the stock of used copies of the traded in book, and giving store credit to the user.  Each book has a specific trade
value which determines how much store credit the user receives when they trade in a book (which is a fraction of the price of the book). The user
can use store credit to pay or partially pay for their books (Store credit is deducted when purchasing a book). There is no trading for digital, or new
books.