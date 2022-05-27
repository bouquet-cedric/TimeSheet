#!/bin/zsh

numberSave=$(cat .number)
sqlite3 src/database.sqlite ".output saves/save_${numberSave}.sql" ".dump"
numberSave=$((numberSave+1))
echo $numberSave > .number
