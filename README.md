# CinemaScript

This scripts finds the best position for a group of visitors with the following
requirements:

1. The lower the seat number, the better
2. If a group can be placed together, place it at the lowest available position
3. If a group can't be placed together, find better places for those who didn't fit
4. The less groups the better.
5. Don't place, for example 2 people, in two groups of 1, when a group of 2 is available.

The script should return an array with chosen seats, and display a visual representation of the cinema floor.

With performance in mind, this script runs in 14 seconds or less when placing a group over 250.000 visitors in a 
cinema with 2 million seats (with 1/4 already taken seats)

Note:
PHP 7 performs this script with much more performance and with much less memory usage. Recommended for stress testing.
