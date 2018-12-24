<?php

use yii\db\Migration;

/**
 * Class m181223_142649_add_start_data
 */
class m181223_142649_add_start_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Add test user
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'test',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('test'),
            'email' => 'test@test.com',
            'created_at' => time(),
            'updated_at' => time()

        ]);

        //Create product table
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'amount' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        //Add some products to product table
        $this->batchInsert('{{%product}}', ['name', 'price', 'amount', 'created_at', 'updated_at'], [
            ['Product 1', 100, 5, time(), time()],
            ['Product 2', 200, 10, time(), time()],
            ['Product 3', 300, 15, time(), time()],
            ['Product 4', 400, 2, time(), time()],
        ]);

        //Create default table
        $this->createTable('{{%default}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'num' => $this->integer()->unsigned(),
            'total' => $this->integer()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)
        ]);

        //Add foreign key to default table for user_id field
        $this->addForeignKey('cart_user_id', '{{%default}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //Create cart_item table
        $this->createTable('{{%cart_item}}', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
            'amount' => $this->integer()->notNull(),
        ]);

        //Add foreign key to cart_item table for cart_id field
        $this->addForeignKey('cart_item_cart_id', '{{%cart_item}}', 'cart_id', '{{%default}}', 'id', 'CASCADE', 'CASCADE');
        //Add foreign key to cart_item table for product_id field
        $this->addForeignKey('cart_item_product_id', '{{%cart_item}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');

        //Create order table
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)
        ]);

        //Add foreign key to order table for cart_id field
        $this->addForeignKey('order_cart_id', '{{%order}}', 'cart_id', '{{%default}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //Drop foreign keys
        $this->dropForeignKey('order_cart_id', '{{%order}}');
        $this->dropForeignKey('cart_item_product_id', '{{%cart_item}}');
        $this->dropForeignKey('cart_item_cart_id', '{{%cart_item}}');
        $this->dropForeignKey('cart_user_id', '{{%default}}');

        ///Drop tables
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%cart_item}}');
        $this->dropTable('{{%default}}');
        $this->dropTable('{{%product}}');

        //Truncate user table
        $this->truncateTable('{{%user}}');
    }
}
