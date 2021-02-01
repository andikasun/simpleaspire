## Dependencies
Laravel Passport

Youtube demonstration: https://youtu.be/0QF3Jfd4_4U

## Epics & Stories
**Epic #1 Create webapp for user to apply for loan online**
Story#1.1 As a user, I want to be able to create and account and login to my account
Story#1.2 As a user, I want to be able to apply for loan by inputting the amount and selecting terms
Story#1.3 As a user, I want to be able to see my payment history
Story#1.4 As a user, I want to be able to pay my weekly repayment

**Epic #2 Create a webapp for an admin user to approve or reject loan**
Story#2.1 As an admin, I want to be able to see the list of loan applications
Story#2.2 As an admin, I want to be able to approve or reject applications
Story#2.3 As an admin, I want to see the breakdown of loan repayment

**Tasks breakdown**
1) Use Laravel Passport to create API that support OAuth2 authentication
2) Create Loan, User and LoanRepayment controllers, models to address the story above
3) Record user's application into database and optionally alert admin about the application
4) If admin approve the application, the Loan will generate the payment_term amount of LoanRepayment
5) Applicant will be able to see each LoanRepayment on their account and press the PAY button to proceed with payment.
6) Create a frontend to demonstrate the functionality of the backend API. The frontend is created using simple blade and jQuery. Data loading are all done via AJAX API, no direct database access is done on the frontend

## Assumptions
1. Since all the loans are assumed to have a “weekly” repayment frequency, the loan term will be simplified and defined in terms of week as well, defined as minimum of 4 and maximum of 36, these are just some arbitrary number that make sense to me.
2. Loan repayment amount is fixed upon creation and the user can't choose how much to pay. This is simplified because the alternative will cause changes on the remaining outstanding payment(s), and I'm not sure the rules of calculation for Aspire in that scenario
3. Due to limited time, I only manage to create 1 role, an admin role (admin@email.com) is hardcoded to approve the loan.
4. Currently we can select any of the repayments without following sequence

The solution consist of backend API and a simple React frontend that consume the API.

## How to run
1) ```git clone```
2) ```composer install```
2) Navigate to the folder simpleaspire and run 
```php artisan migrate:refresh --seed```
3) Navigate to simpleaspire and run
```php artisan serve ```

Sample user created in seeder:
email: andika.sun@gmail.com
password: password123

Sample admin created in seeder:
email: admin@email.com
password: password123

To run the test
Navigate to simpleaspire and run
```
./vendor/bin/phpunit
```
