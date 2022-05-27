numberSave := $(shell cat saves/.number)
number2 := $(shell expr $(cat saves/.number) + 1)

save:
	@eval "echo -n 'Sauvegarde en cours '"
	@sleep 1
	@sqlite3 src/database.sqlite ".output saves/save_$(numberSave).sql" ".dump" && eval "echo -n '.'"
	@sleep 1
	@echo $(number2) > saves/.number && eval "echo -n '.'"
	@sleep 1
	@eval "echo \"\b\b\0342\0234\0224   \"" 

clean:
	@eval "echo -n 'Cleaning '"
	@sleep 1
	@rm saves/*.sql 2> /dev/null || eval "echo -n ''"
	@sleep 1 && eval "echo -n '.'" 
	@echo 1 > saves/.number
	@sleep 1 && eval "echo -n '.'" 
	@eval "echo \"\b\b\0342\0234\0224   \"" 

clean-update: clean save
