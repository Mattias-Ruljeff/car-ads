#!/bin/bash
git add .;
echo "Add commit message:";
read message;
git commit -m "$message";
git push;
git push heroku master;
