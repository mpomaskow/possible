<?php


/**
 * This class defines the structure of the 'osoby' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class OsobyTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.OsobyTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('osoby');
		$this->setPhpName('Osoby');
		$this->setClassname('Osoby');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NAZWISKO', 'Nazwisko', 'VARCHAR', true, 255, null);
		$this->addColumn('IMIE', 'Imie', 'VARCHAR', true, 255, null);
		$this->addForeignKey('MIEJSCOWOSC', 'Miejscowosc', 'INTEGER', 'miejscowosci', 'ID', true, 11, null);
		$this->addColumn('DATA_URODZENIA', 'DataUrodzenia', 'DATE', true, null, null);
		$this->addForeignKey('FIRMA', 'Firma', 'INTEGER', 'firmy', 'ID', true, 11, null);
		$this->addForeignKey('ODDZIAL_FIRMY', 'OddzialFirmy', 'INTEGER', 'oddzialy_firmy', 'ID', true, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Miejscowosci', 'Miejscowosci', RelationMap::MANY_TO_ONE, array('miejscowosc' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Firmy', 'Firmy', RelationMap::MANY_TO_ONE, array('firma' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('OddzialyFirmy', 'OddzialyFirmy', RelationMap::MANY_TO_ONE, array('oddzial_firmy' => 'id', ), 'CASCADE', 'CASCADE');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // OsobyTableMap
