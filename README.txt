Readme

Query 1
-A customer can register on the registry page.  Once the registration is complete they may login in.  By selecting the membership settings
page, a customer can upgrade to become a member.  In order to do so, they must enter their payment information.  Also, on the membership
settings page is the ability for members to terminate their membership.

Query 2
-A publisher can log in using the publisher log in page.  Once logged in, publishers can click the add new book or change price page to
add a new book to the bookstore or change the price of an existing book that they have published.  Note that by adding a new book, a used
variant of the book is automatically added to the book store at a discounted price, and a trade value is generated for that book which
is a fraction of the price (unless the book is digital in which case there is no trade value or used variant).  By updating the price, 
the system will also update the price of the used copy and the trade value of the book.

Query 3
-The super user can log in on the user login page byy entering in "SPECIAL" for an email and "securepassword" as the password.  They can see most of
the pages that a typical user can see (excluding the special page for authors to view their books) plus some extras.  In the case of query 3, the super
user can click on the update shipping cost page.  They can then fill out a short form to update the shipping cost.

Query 4
-There are a few different ways a customer can search for a book.  They can either search with a keyword on the Book Search page or the may view a list
of all the books on the view books page.  On the Book Search page customers may enter the title, author, genre, or ISBN of the book.  Once entered,
all the books that fit the search critera will be listed.  The title and author don't need to be exact to function, but the genre and ISBN do.  Once they
find the book they are looking for, users may add them to their cart by clicking add to cart. 
-For guests the process is slightly different.  Each guest must be given a shopping cart before they can add to cart.  In order to do so, each guest must
give the book store some information.  Hence, if the guest does not have a shopping cart, they will be redirected to a page where they can fill out 
information so that one can be given to them.  However, guest may still view all the books without having to enter in any information (they just can't
add them to their cart).
-Purchasing books functions the same way for guests and registered users.  Each user must go to their shopping cart.  There, they can edit their cart by
removing books if they'd like.  Once done, they can hit purchase where they will then be prompted to fill out credit card information and to give the store
an address to ship to.  They then click purchase completing the purchase.  For shipping costs, paying members will receive free, express shipping while all
other users receive standard shipping and a fee for doing so.  The exception is for digital books which always have free shipping.  When purchasing
books store credit will be deducted and used towards payments if the user has any.  Behind the scenes the payment information is recorded in the database, 
an order is created, and the books ordered a recorded as being a part of the order.  The shopping cart is also emptied.

Extra Features

-By logging in as a publisher you can select go to an analytics page.  This page will give you information about how well your books have sold 
including how many units have been sold, how much money that has generated and how many wishlists your book is on.

-Customers who create an account can add books to their wishlist.  Once a user has added a book to their wishlist, they may come back
later and add the book to cart.  They may also remove the book from their wishlist.  The key feature that differentiates the wishlist from
the shopping cart is the wishlists are public.  Other users may search for a wishlist by entering in a user's email and they can then see
the wishlist of that person.  In that way, other people may get gift ideas for the person they are searching up.  People searching someone's
wishlist may also choose to add the book to their cart or their own wishlist, but they can't remove books from other people's wishlists.

-The most complex special feature is the ability to trade books in.  In this way, the book store would be able to sell used books traded in
by customers in a fashion similar to that of GameStop.  Each users who is logged in can elect to trade in a book by clicking the trade button
available on the View Books page or in the Book Search page.  The user will then be prompted to sent the book to a certain location.  Once 
the book store has received the book, a moderator (in this case the super user) can log in and fill out a short form specifying the book has
been successfully traded in (this small form is called the "Update Trade" form).  When finished the database will update to record that the book
was successfully traded in, increasing the stock of used copies of the book, and giving store credit to the user.  Each book has a specific trade
value which determines how much store credit the user receives when they trade in the book (which is a fraction of the price of the book). The user
can use store credit to pay or partially pay for their books (Store credit is deducted when purchasing a book). There is no trading for digital, or new
books.