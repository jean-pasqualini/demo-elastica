demo:
	@bin/console doctrine:database:drop --force
	@bin/console doctrine:database:create
	@bin/console doctrine:schema:update --force
	@bin/console f:e:p
	@echo 'attention elastica va s\'amuser à modifier l'index en fonciton des données dans 5secondes...' && sleep 5
	@bin/console app:product create --integer
	@bin/console app:product create
	@bin/console app:product list
