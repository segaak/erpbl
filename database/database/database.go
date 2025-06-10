package database

import (
	"database/sql"

	_ "github.com/go-sql-driver/mysql" // MySQL driver
)

func InitDatabase() *sql.DB {
	// Initialize the database connection here
	// This is a placeholder function
	// Actual implementation will depend on the specific database being used
	dsn := "root@tcp(localhost:3306)/sisupply"
	db, err := sql.Open("mysql", dsn)
	if err != nil {
		panic(err)
	}

	err = db.Ping()
	if err != nil {
		panic(err)
	}

	return db
}
