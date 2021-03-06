<?php

namespace NsplTest;

use function \nspl\args\expects;
use function \nspl\args\expectsAll;
use function \nspl\args\expectsOptional;

// Or-constraints
use const \nspl\args\bool;
use const \nspl\args\int;
use const \nspl\args\float;
use const \nspl\args\numeric;
use const \nspl\args\string;
use const \nspl\args\callable_;
use const \nspl\args\arrayKey;
use const \nspl\args\traversable;
use const \nspl\args\arrayAccess;

// And-constraints
use const \nspl\args\nonEmpty;
use const \nspl\args\positive;
use const \nspl\args\nonNegative;
use const \nspl\args\nonZero;
use function \nspl\args\any;
use function \nspl\args\not;
use function \nspl\args\values;
use function \nspl\args\withMethod;
use function \nspl\args\withMethods;
use function \nspl\args\withKey;
use function \nspl\args\withKeys;
use function \nspl\args\longerThan;
use function \nspl\args\shorterThan;
use function \nspl\args\biggerThan;
use function \nspl\args\smallerThan;

// @todo Move deprecated stuff into a separate test
use function \nspl\args\expectsNotEmpty;
use function \nspl\args\expectsBool;
use function \nspl\args\expectsInt;
use function \nspl\args\expectsFloat;
use function \nspl\args\expectsNumeric;
use function \nspl\args\expectsString;
use function \nspl\args\expectsArrayKey;
use function \nspl\args\expectsTraversable;
use function \nspl\args\expectsArrayAccess;
use function \nspl\args\expectsArrayAccessOrString;
use function \nspl\args\expectsArrayKeyOrCallable;
use function \nspl\args\expectsBoolOrCallable;
use function \nspl\args\expectsWithMethod;
use function \nspl\args\expectsWithMethods;
use function \nspl\args\expectsWithKeys;
use function \nspl\args\expectsToBe;

class ArgsTest extends \PHPUnit_Framework_TestCase
{
    // Or-constraints
    #region bool
    public function testExpectsBool_Positive()
    {
        function expectsBoolPositiveTest($arg) { expects(bool, $arg); }
        $this->assertNull(expectsBoolPositiveTest(true));
        $this->assertNull(expectsBoolPositiveTest(false));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsBoolNegativeTest() must be a boolean, integer 1 given
     */
    public function testExpectsBool_Negative()
    {
        function expectsBoolNegativeTest($arg) { expects(bool, $arg); }
        $this->assertNull(expectsBoolNegativeTest(1));
    }
    #endregion

    #region int
    public function testExpectsInt_Positive()
    {
        function expectsIntPositiveTest($arg1, $arg2) { expects(int, $arg2); }
        $this->assertNull(expectsIntPositiveTest(true, 1));
        $this->assertNull(expectsIntPositiveTest('hello world', 0));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\expectsIntNegativeTest() must be an integer, string '1' given
     */
    public function testExpectsInt_Negative()
    {
        function expectsIntNegativeTest($arg1, $arg2) { expects(int, $arg2); }
        $this->assertNull(expectsIntNegativeTest('hello world', '1'));
    }
    #endregion

    #region float
    public function testExpectsFloat_Positive()
    {
        function expectsFloatPositiveTest($arg1, $arg2) { expects(float, $arg1); }
        $this->assertNull(expectsFloatPositiveTest(1.0, 'hello'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsFloatNegativeTest() must be a float, string 'hello' given
     */
    public function testExpectsFloat_Negative()
    {
        function expectsFloatNegativeTest($arg1, $arg2) { expects(float, $arg1); }
        $this->assertNull(expectsFloatNegativeTest('hello', 'world'));
    }
    #endregion

    #region numeric
    public function testExpectsNumeric_Positive()
    {
        function expectsNumericPositiveTest($arg1, $arg2) { expects(numeric, $arg2); }
        $this->assertNull(expectsNumericPositiveTest('answer', 42));
        $this->assertNull(expectsNumericPositiveTest('web', 2.0));
        $this->assertNull(expectsNumericPositiveTest('number -> ', '1'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\expectsNumericNegativeTest() must be numeric, string 'world' given
     */
    public function testExpectsNumeric_Negative()
    {
        function expectsNumericNegativeTest($arg1, $arg2) { expects(numeric, $arg2); }
        $this->assertNull(expectsNumericNegativeTest('hello', 'world'));
    }
    #endregion

    #region string
    public function testExpectsString_Positive()
    {
        function expectsStringPositiveTest($arg1, $arg2) { expects(string, $arg2, 2); }
        $this->assertNull(expectsStringPositiveTest(42, 'answer'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\expectsStringNegativeTest() must be a string, integer 42 given
     */
    public function testExpectsString_Negative()
    {
        function expectsStringNegativeTest($arg1, $arg2) { expects(string, $arg2, 2); }
        $this->assertNull(expectsStringNegativeTest(42, 42));
    }
    #endregion

    #region arrayKey
    public function testExpectsArrayKey_Positive()
    {
        function expectsArrayKeyPositiveTest($arg1, $arg2) { expects(arrayKey, $arg1); }
        $this->assertNull(expectsArrayKeyPositiveTest(42, 'answer'));
        $this->assertNull(expectsArrayKeyPositiveTest('answer', 42));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsArrayKeyNegativeTest() must be an integer or a string, double 2 given
     */
    public function testExpectsArrayKey_Negative()
    {
        function expectsArrayKeyNegativeTest($arg1, $arg2) { expects(arrayKey, $arg1); }
        $this->assertNull(expectsArrayKeyNegativeTest(2.0, 2.0));
    }
    #endregion

    #region traversable
    public function testExpectsTraversable_Positive()
    {
        function expectsTraversablePositiveTest($arg1) { expects(traversable, $arg1); }
        $this->assertNull(expectsTraversablePositiveTest(array('hello', 'world')));
        $this->assertNull(expectsTraversablePositiveTest(new \ArrayIterator(array('hello', 'world'))));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsTraversableNegativeTest() must be an array or traversable, string 'hello world' given
     */
    public function testExpectsTraversable_Negative()
    {
        function expectsTraversableNegativeTest($arg1) { expects(traversable, $arg1); }
        $this->assertNull(expectsTraversableNegativeTest('hello world'));
    }
    #endregion

    #region arrayAccess
    public function testExpectsArrayAccess_Positive()
    {
        function expectsArrayAccessPositiveTest($arg1) { expects(arrayAccess, $arg1); }
        $this->assertNull(expectsTraversablePositiveTest(array('hello', 'world')));
        $this->assertNull(expectsTraversablePositiveTest(new \ArrayObject(array('hello', 'world'))));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsArrayAccessNegativeTest() must be an array or implement array access, string 'hello world' given
     */
    public function testExpectsArrayAccess_Negative()
    {
        function expectsArrayAccessNegativeTest($arg1) { expects(arrayAccess, $arg1); }
        $this->assertNull(expectsArrayAccessNegativeTest('hello world'));
    }
    #endregion

    #region Classes
    public function testExpectsUserDefinedType_Positive()
    {
        function expectsUserDefinedTypePositiveTest($arg1) { expects([int, TestClass::class], $arg1); }
        $this->assertNull(expectsUserDefinedTypePositiveTest(1));
        $this->assertNull(expectsUserDefinedTypePositiveTest(new TestClass()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsUserDefinedTypeNegativeTest() must be an integer or be NsplTest\TestClass, string 'hello world' given
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsUserDefinedTypeNegativeTest() must be an integer or NsplTest\TestClass, string 'hello world' given
     */
    public function testExpectsWithCustomType_Negative()
    {
        function expectsUserDefinedTypeNegativeTest($arg1) { expects([int, TestClass::class], $arg1); }
        $this->assertNull(expectsUserDefinedTypeNegativeTest('hello world'));
    }

    public function testExpectsTwoClasses_Positive()
    {
        function expectsTwoClassesPositiveTest($arg1) { expects([TestClass::class, TestClass2::class], $arg1); }
        $this->assertNull(expectsTwoClassesPositiveTest(new TestClass()));
        $this->assertNull(expectsTwoClassesPositiveTest(new TestClass2()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsTwoClassesNegativeTest() must be NsplTest\TestClass or be NsplTest\TestClass2, integer 1 given
     */
    public function testExpectsTwoClasses_Negative()
    {
        function expectsTwoClassesNegativeTest($arg1) { expects([TestClass::class, TestClass2::class], $arg1); }
        $this->assertNull(expectsTwoClassesNegativeTest(1));
    }
    #endregion

    // And-constraints
    #region nonEmpty
    public function testExpectsNonEmpty_Positive()
    {
        function expectsNonEmptyPositiveTest($arg) { expects(nonEmpty, $arg); }
        $this->assertNull(expectsNonEmptyPositiveTest(true));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsNonEmptyNegativeTest() must not be empty, integer 0 given
     */
    public function testExpectsNonEmpty_Negative()
    {
        function expectsNonEmptyNegativeTest($arg) { expects(nonEmpty, $arg); }
        $this->assertNull(expectsNonEmptyNegativeTest(0));
    }
    #endregion

    #region positive
    public function testExpectsPositive_Positive()
    {
        function expectsPositivePositiveTest($arg) { expects([positive, int], $arg); }
        $this->assertNull(expectsPositivePositiveTest(1));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsPositiveNegativeTest() must be an integer and be positive, integer 0 given
     */
    public function testExpectsPositive_Negative()
    {
        function expectsPositiveNegativeTest($arg) { expects([positive, int], $arg); }
        $this->assertNull(expectsPositiveNegativeTest(0));
    }
    #endregion

    #region nonNegative
    public function testExpectsNonNegative_Positive()
    {
        function expectsNonNegativePositiveTest($arg) { expects([nonNegative, int], $arg); }
        $this->assertNull(expectsNonNegativePositiveTest(1));
        $this->assertNull(expectsNonNegativePositiveTest(0));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsNonNegativeNegativeTest() must be an integer and be non-negative, integer -1 given
     */
    public function testExpectsNonNegative_Negative()
    {
        function expectsNonNegativeNegativeTest($arg) { expects([nonNegative, int], $arg); }
        $this->assertNull(expectsNonNegativeNegativeTest(-1));
    }
    #endregion

    #region nonZero
    public function testExpectsNonZero_Positive()
    {
        function expectsNonZeroPositiveTest($arg) { expects([nonZero, int], $arg); }
        $this->assertNull(expectsNonZeroPositiveTest(1));
        $this->assertNull(expectsNonZeroPositiveTest(-1));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsNonZeroNegativeTest() must be an integer and be non-zero, integer 0 given
     */
    public function testExpectsNonZero_Negative()
    {
        function expectsNonZeroNegativeTest($arg) { expects([nonZero, int], $arg); }
        $this->assertNull(expectsNonZeroNegativeTest(0));
    }
    #endregion

    #region value
    public function testExpectsValues_Positive()
    {
        function expectsValuesPositiveTest($arg) { expects(values('hello', 'world'), $arg); }
        $this->assertNull(expectsValuesPositiveTest('hello'));
        $this->assertNull(expectsValuesPositiveTest('world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsValuesNegativeTest() must be one of the following values 'hello', 'world', integer 1 given
     */
    public function testExpectsValues_Negative()
    {
        function expectsValuesNegativeTest($arg) { expects(values('hello', 'world'), $arg); }
        $this->assertNull(expectsValuesNegativeTest(1));
    }
    #endregion

    #region longerThan
    public function testExpectLongerThan_Positive()
    {
        function expectsLongerThanPositiveTest($arg1) { expects(longerThan(6), $arg1); }
        $this->assertNull(expectsLongerThanPositiveTest('hello world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsLongerThanNegativeTest() must be longer than 6, string 'hello' given
     */
    public function testExpectsLongerThan_Negative()
    {
        function expectsLongerThanNegativeTest($arg1) { expects(longerThan(6), $arg1); }
        $this->assertNull(expectsLongerThanNegativeTest('hello'));
    }
    #endregion

    #region shorterThan
    public function testExpectShorterThan_Positive()
    {
        function expectsShorterThanPositiveTest($arg1) { expects(shorterThan(6), $arg1); }
        $this->assertNull(expectsShorterThanPositiveTest('hello'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsShorterThanNegativeTest() must be shorter than 6, string 'hello world' given
     */
    public function testExpectsShorterThan_Negative()
    {
        function expectsShorterThanNegativeTest($arg1) { expects(shorterThan(6), $arg1); }
        $this->assertNull(expectsShorterThanNegativeTest('hello world'));
    }
    #endregion

    #region biggerThan
    public function testExpectBiggerThan_Positive()
    {
        function expectsBiggerThanPositiveTest($arg1) { expects(biggerThan(2), $arg1); }
        $this->assertNull(expectsBiggerThanPositiveTest(3));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsBiggerThanNegativeTest() must be bigger than 2, integer 1 given
     */
    public function testExpectsBiggerThan_Negative()
    {
        function expectsBiggerThanNegativeTest($arg1) { expects(biggerThan(2), $arg1); }
        $this->assertNull(expectsBiggerThanNegativeTest(1));
    }
    #endregion

    #region smallerThan
    public function testExpectSmallerThan_Positive()
    {
        function expectsSmallerThanPositiveTest($arg1) { expects(smallerThan(2), $arg1); }
        $this->assertNull(expectsSmallerThanPositiveTest(1));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsSmallerThanNegativeTest() must be smaller than 2, integer 3 given
     */
    public function testExpectsSmallerThan_Negative()
    {
        function expectsSmallerThanNegativeTest($arg1) { expects(smallerThan(2), $arg1); }
        $this->assertNull(expectsSmallerThanNegativeTest(3));
    }
    #endregion

    #region withMethod
    public function testExpectWithMethod_Positive()
    {
        function expectsWithMethodPositiveTest($arg1) { expects(withMethod('testMethod1'), $arg1); }
        $this->assertNull(expectsWithMethodPositiveTest(new TestClass()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsWithMethodNegativeTest() must be an object with public method(s) 'test_Method_1', NsplTest\TestClass given
     */
    public function testExpectsWithMethod_Negative()
    {
        function expectsWithMethodNegativeTest($arg1) { expects(withMethod('test_Method_1'), $arg1); }
        $this->assertNull(expectsWithMethodNegativeTest(new TestClass()));
    }
    #endregion

    #region withMethods
    public function testExpectsWithMethods_Positive()
    {
        function expectsWithMethodsPositiveTest($arg1) { expects(withMethods('testMethod1', 'testMethod2'), $arg1); }
        $this->assertNull(expectsWithMethodsPositiveTest(new TestClass()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsWithMethodsNegativeTest() must be an object with public method(s) 'testMethod1', 'test_Method_2', NsplTest\TestClass given
     */
    public function testExpectsWithMethods_Negative()
    {
        function expectsWithMethodsNegativeTest($arg1) { expects(withMethods('testMethod1', 'test_Method_2'), $arg1); }
        $this->assertNull(expectsWithMethodsNegativeTest(new TestClass()));
    }
    #endregion

    #region withKey
    public function testExpectsWithKey_Positive()
    {
        function expectsWithKeyPositiveTest($arg1) { expects(withKey('hello'), $arg1); }
        $this->assertNull(expectsWithKeyPositiveTest(array('hello' => 'world')));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsWithKeyNegativeTest() must be an array with key(s) 'answer'
     */
    public function testExpectsWithKey_Negative()
    {
        function expectsWithKeyNegativeTest($arg1) { expects(withKey('answer'), $arg1); }
        $this->assertNull(expectsWithKeyNegativeTest(array('hello' => 'world')));
    }
    #endregion

    #region withKeys
    public function testExpectsWithKeys_Positive()
    {
        function expectsWithKeysPositiveTest($arg1) { expects(withKeys('hello', 'answer'), $arg1); }
        $this->assertNull(expectsWithKeysPositiveTest(array(
            'hello' => 'world',
            'answer' => 42,
        )));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsWithKeysNegativeTest() must be an array with key(s) 'hello', 'answer'
     */
    public function testExpectsWithKeys_Negative()
    {
        function expectsWithKeysNegativeTest($arg1) { expects(withKeys('hello', 'answer'), $arg1); }
        $this->assertNull(expectsWithKeysNegativeTest(array('hello' => 'world')));
    }
    #endregion

    #region not
    public function testExpectsNotPositive_Positive()
    {
        function expectsNotPositivePositiveTest($arg) { expects(not(positive), $arg); }
        $this->assertNull(expectsNotPositivePositiveTest(0));
        $this->assertNull(expectsNotPositivePositiveTest(-1));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsNotPositiveNegativeTest() must not be be positive, integer 1 given
     */
    public function testExpectsNotPositive_Negative()
    {
        function expectsNotPositiveNegativeTest($arg) { expects(not(positive), $arg); }
        $this->assertNull(expectsNotPositiveNegativeTest(1));
    }
    #endregion

    #region any
    public function testExpectsAny_Positive()
    {
        function expectsAnyPositiveTest($arg) { expects(any(shorterThan(6), longerThan(10)), $arg); }
        $this->assertNull(expectsAnyPositiveTest('hello'));
        $this->assertNull(expectsAnyPositiveTest('hello world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsAnyNegativeTest() must be be shorter than 6 or be longer than 10, string 'answer' given
     */
    public function testExpectsAny_Negative()
    {
        function expectsAnyNegativeTest($arg) { expects(any(shorterThan(6), longerThan(10)), $arg); }
        $this->assertNull(expectsAnyNegativeTest('answer'));
    }
    #endregion

    // Other tests
    #region Several or-constraints
    public function testExpectsArrayAccessOrString_Positive()
    {
        function expectsArrayAccessOrStringPositiveTest($arg1) { expects([arrayAccess, string], $arg1); }
        $this->assertNull(expectsArrayAccessOrStringPositiveTest(array('hello', 'world')));
        $this->assertNull(expectsArrayAccessOrStringPositiveTest(new \ArrayObject(array('hello', 'world'))));
        $this->assertNull(expectsArrayAccessOrStringPositiveTest('hello world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsArrayAccessOrStringNegativeTest() must be an array or implement array access or be a string, integer 1337 given
     */
    public function testExpectsArrayAccessOrString_Negative()
    {
        function expectsArrayAccessOrStringNegativeTest($arg1) { expects([arrayAccess, string], $arg1); }
        $this->assertNull(expectsArrayAccessOrStringNegativeTest(1337));
    }

    public function testExpectsArrayKeyOrCallable_Positive()
    {
        function expectsArrayKeyOrCallablePositiveTest($arg1) { expects([arrayKey, callable_], $arg1); }
        $this->assertNull(expectsArrayKeyOrCallablePositiveTest(42));
        $this->assertNull(expectsArrayKeyOrCallablePositiveTest('answer'));
        $this->assertNull(expectsArrayKeyOrCallablePositiveTest(function() { return 'answer 42'; }));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsArrayKeyOrCallableNegativeTest() must be an integer or a string or be callable, double 2 given
     */
    public function testExpectsArrayKeyOrCallable_Negative()
    {
        function expectsArrayKeyOrCallableNegativeTest($arg1) { expects([arrayKey, callable_], $arg1); }
        $this->assertNull(expectsArrayKeyOrCallableNegativeTest(2.0));
    }

    public function testExpectsBoolOrCallable_Positive()
    {
        function expectsBoolOrCallablePositiveTest($arg1) { expects([bool, callable_], $arg1); }
        $this->assertNull(expectsBoolOrCallablePositiveTest(true));
        $this->assertNull(expectsBoolOrCallablePositiveTest(function() { return 'answer 42'; }));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsBoolOrCallableNegativeTest() must be a boolean or be callable, double 2 given
     */
    public function testExpectsBoolOrCallable_Negative()
    {
        function expectsBoolOrCallableNegativeTest($arg1) { expects([bool, callable_], $arg1); }
        $this->assertNull(expectsBoolOrCallableNegativeTest(2.0));
    }
    #endregion

    #region Or-constraints and and-constraints together
    public function testExpectsAndRequirementAndOrRequirement_Positive()
    {
        function expectsAndRequirementAndOrRequirementPositiveTest($arg1) { expects([nonEmpty, string], $arg1); }
        $this->assertNull(expectsAndRequirementAndOrRequirementPositiveTest('hello world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsAndRequirementAndOrRequirementNegativeTest1() must be a string and not be empty, string '' given
     */
    public function testExpectsAndRequirementAndOrRequirement_Negative1()
    {
        function expectsAndRequirementAndOrRequirementNegativeTest1($arg1) { expects([nonEmpty, string], $arg1); }
        $this->assertNull(expectsAndRequirementAndOrRequirementNegativeTest1(''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsAndRequirementAndOrRequirementNegativeTest2() must be a string and not be empty, integer 1 given
     */
    public function testExpectsAndRequirementAndOrRequirement_Negative2()
    {
        function expectsAndRequirementAndOrRequirementNegativeTest2($arg1) { expects([nonEmpty, string], $arg1); }
        $this->assertNull(expectsAndRequirementAndOrRequirementNegativeTest2(1));
    }
    #endregion

    #region expectsOptional
    public function testExpectsOptionalInt_Positive()
    {
        function expectsOptionalIntPositiveTest($arg1 = null) { expectsOptional([int], $arg1); }
        $this->assertNull(expectsOptionalIntPositiveTest());
        $this->assertNull(expectsOptionalIntPositiveTest(1));
        $this->assertNull(expectsOptionalIntPositiveTest(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsOptionalIntNegativeTest() must be an integer, string '1' given
     */
    public function testExpectsOptionalInt_Negative()
    {
        function expectsOptionalIntNegativeTest($arg1) { expectsOptional([int], $arg1); }
        $this->assertNull(expectsOptionalIntNegativeTest('1'));
    }
    #endregion

    #region expectsAll
    public function testExpectsInts_Positive()
    {
        function expectsIntsPositiveTest($x, $y) { expectsAll(int, [$x, $y]); }
        $this->assertNull(expectsIntsPositiveTest(1, 2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsIntsNegativeTest() must be an integer, string '1' given
     */
    public function testExpectsInts_Negative()
    {
        function expectsIntsNegativeTest($x, $y) { expectsAll(int, [$x, $y]); }
        $this->assertNull(expectsIntsNegativeTest('1', 2));
    }
    #endregion

    #region Custom constraints
    public function testCustomConstraint_Positive()
    {
        function expectsCustomConstraintPositiveTest($year) { expects(validYear, $year); }
        $this->assertNull(expectsCustomConstraintPositiveTest(2000));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsCustomConstraintNegativeTest() must be valid year, integer 1000 given
     */
    public function testCustomConstraint_Negative()
    {
        function expectsCustomConstraintNegativeTest($year) { expects(validYear, $year); }
        $this->assertNull(expectsCustomConstraintNegativeTest(1000));
    }
    #endregion

    #region Custom exception
    /**
     * @expectedException \BadFunctionCallException
     * @expectedExceptionMessage Function NsplTest\expectsWithCustomExceptionTest() does not like the given input
     */
    public function testExpectsWithCustomException()
    {
        function expectsWithCustomExceptionTest($arg1)
        {
            expects(bool, $arg1, 1, new \BadFunctionCallException(
                'Function NsplTest\expectsWithCustomExceptionTest() does not like the given input'
            ));
        }

        $this->assertNull(expectsWithCustomExceptionTest('true'));
    }
    #endregion

    #region Exception data
    public function testExpectsExceptionFileAndLine()
    {
        function expectsExceptionFileAndLineTest($arg) { expects(bool, $arg); }
        try {
            expectsExceptionFileAndLineTest('true');
        }
        catch (\InvalidArgumentException $e) {
            $this->assertEquals(__FILE__, $e->getFile());
            $this->assertEquals(__LINE__ - 4, $e->getLine());
        }
    }
    #endregion

    #region Deprecated
    public function testDeprecatedExpectsNotEmpty_Positive()
    {
        function deprecatedExpectsNotEmptyPositiveTest($arg) { expectsNotEmpty($arg); }
        $this->assertNull(deprecatedExpectsNotEmptyPositiveTest(true));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsNotEmptyNegativeTest() must not be empty, integer 0 given
     */
    public function testDeprecatedExpectsNotEmpty_Negative()
    {
        function deprecatedExpectsNotEmptyNegativeTest($arg) { expectsNotEmpty($arg); }
        $this->assertNull(deprecatedExpectsNotEmptyNegativeTest(0));
    }

    public function testDeprecatedExpectsBool_Positive()
    {
        function deprecatedExpectsBoolPositiveTest($arg) { expectsBool($arg); }
        $this->assertNull(deprecatedExpectsBoolPositiveTest(true));
        $this->assertNull(deprecatedExpectsBoolPositiveTest(false));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsBoolNegativeTest() must be a boolean, integer 1 given
     */
    public function testDeprecatedExpectsBool_Negative()
    {
        function deprecatedExpectsBoolNegativeTest($arg) { expectsBool($arg); }
        $this->assertNull(deprecatedExpectsBoolNegativeTest(1));
    }

    public function testDeprecatedExpectsInt_Positive()
    {
        function deprecatedExpectsIntPositiveTest($arg1, $arg2) { expectsInt($arg2); }
        $this->assertNull(deprecatedExpectsIntPositiveTest(true, 1));
        $this->assertNull(deprecatedExpectsIntPositiveTest('hello world', 0));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\deprecatedExpectsIntNegativeTest() must be an integer, string '1' given
     */
    public function testDeprecatedExpectsInt_Negative()
    {
        function deprecatedExpectsIntNegativeTest($arg1, $arg2) { expectsInt($arg2); }
        $this->assertNull(deprecatedExpectsIntNegativeTest('hello world', '1'));
    }

    public function testDeprecatedExpectsFloat_Positive()
    {
        function deprecatedExpectsFloatPositiveTest($arg1, $arg2) { expectsFloat($arg1); }
        $this->assertNull(deprecatedExpectsFloatPositiveTest(1.0, 'hello'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsFloatNegativeTest() must be a float, string 'hello' given
     */
    public function testDeprecatedExpectsFloat_Negative()
    {
        function deprecatedExpectsFloatNegativeTest($arg1, $arg2) { expectsFloat($arg1); }
        $this->assertNull(deprecatedExpectsFloatNegativeTest('hello', 'world'));
    }

    public function testDeprecatedExpectsNumeric_Positive()
    {
        function deprecatedExpectsNumericPositiveTest($arg1, $arg2) { expectsNumeric($arg2); }
        $this->assertNull(deprecatedExpectsNumericPositiveTest('answer', 42));
        $this->assertNull(deprecatedExpectsNumericPositiveTest('web', 2.0));
        $this->assertNull(deprecatedExpectsNumericPositiveTest('number -> ', '1'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\deprecatedExpectsNumericNegativeTest() must be numeric, string 'world' given
     */
    public function testDeprecatedExpectsNumeric_Negative()
    {
        function deprecatedExpectsNumericNegativeTest($arg1, $arg2) { expectsNumeric($arg2); }
        $this->assertNull(deprecatedExpectsNumericNegativeTest('hello', 'world'));
    }

    public function testDeprecatedExpectsString_Positive()
    {
        function deprecatedExpectsStringPositiveTest($arg1, $arg2) { expectsString($arg2, 2); }
        $this->assertNull(deprecatedExpectsStringPositiveTest(42, 'answer'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 2 passed to NsplTest\deprecatedExpectsStringNegativeTest() must be a string, integer 42 given
     */
    public function testDeprecatedExpectsString_Negative()
    {
        function deprecatedExpectsStringNegativeTest($arg1, $arg2) { expectsString($arg2, 2); }
        $this->assertNull(deprecatedExpectsStringNegativeTest(42, 42));
    }

    public function testDeprecatedExpectsArrayKey_Positive()
    {
        function deprecatedExpectsArrayKeyPositiveTest($arg1, $arg2) { expectsArrayKey($arg1); }
        $this->assertNull(deprecatedExpectsArrayKeyPositiveTest(42, 'answer'));
        $this->assertNull(deprecatedExpectsArrayKeyPositiveTest('answer', 42));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsArrayKeyNegativeTest() must be an integer or a string, double 2 given
     */
    public function testDeprecatedExpectsArrayKey_Negative()
    {
        function deprecatedExpectsArrayKeyNegativeTest($arg1, $arg2) { expectsArrayKey($arg1); }
        $this->assertNull(deprecatedExpectsArrayKeyNegativeTest(2.0, 2.0));
    }

    public function testDeprecatedExpectsTraversable_Positive()
    {
        function deprecatedExpectsTraversablePositiveTest($arg1) { expectsTraversable($arg1); }
        $this->assertNull(deprecatedExpectsTraversablePositiveTest(array('hello', 'world')));
        $this->assertNull(deprecatedExpectsTraversablePositiveTest(new \ArrayIterator(array('hello', 'world'))));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsTraversableNegativeTest() must be an array or traversable, string 'hello world' given
     */
    public function testDeprecatedExpectsTraversable_Negative()
    {
        function deprecatedExpectsTraversableNegativeTest($arg1) { expectsTraversable($arg1); }
        $this->assertNull(deprecatedExpectsTraversableNegativeTest('hello world'));
    }

    public function testDeprecatedExpectsArrayAccess_Positive()
    {
        function deprecatedExpectsArrayAccessPositiveTest($arg1) { expectsArrayAccess($arg1); }
        $this->assertNull(deprecatedExpectsTraversablePositiveTest(array('hello', 'world')));
        $this->assertNull(deprecatedExpectsTraversablePositiveTest(new \ArrayObject(array('hello', 'world'))));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsArrayAccessNegativeTest() must be an array or implement array access, string 'hello world' given
     */
    public function testDeprecatedExpectsArrayAccess_Negative()
    {
        function deprecatedExpectsArrayAccessNegativeTest($arg1) { expectsArrayAccess($arg1); }
        $this->assertNull(deprecatedExpectsArrayAccessNegativeTest('hello world'));
    }

    public function testDeprecatedExpectsArrayAccessOrString_Positive()
    {
        function deprecatedExpectsArrayAccessOrStringPositiveTest($arg1) { expectsArrayAccessOrString($arg1); }
        $this->assertNull(deprecatedExpectsArrayAccessOrStringPositiveTest(array('hello', 'world')));
        $this->assertNull(deprecatedExpectsArrayAccessOrStringPositiveTest(new \ArrayObject(array('hello', 'world'))));
        $this->assertNull(deprecatedExpectsArrayAccessOrStringPositiveTest('hello world'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsArrayAccessOrStringNegativeTest() must be a string, an array or implement array access, integer 1337 given
     */
    public function testDeprecatedExpectsArrayAccessOrString_Negative()
    {
        function deprecatedExpectsArrayAccessOrStringNegativeTest($arg1) { expectsArrayAccessOrString($arg1); }
        $this->assertNull(deprecatedExpectsArrayAccessOrStringNegativeTest(1337));
    }

    public function testDeprecatedExpectsArrayKeyOrCallable_Positive()
    {
        function deprecatedExpectsArrayKeyOrCallablePositiveTest($arg1) { expectsArrayKeyOrCallable($arg1); }
        $this->assertNull(deprecatedExpectsArrayKeyOrCallablePositiveTest(42));
        $this->assertNull(deprecatedExpectsArrayKeyOrCallablePositiveTest('answer'));
        $this->assertNull(deprecatedExpectsArrayKeyOrCallablePositiveTest(function() { return 'answer 42'; }));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsArrayKeyOrCallableNegativeTest() must be an integer or a string or a callable, double 2 given
     */
    public function testDeprecatedExpectsArrayKeyOrCallable_Negative()
    {
        function deprecatedExpectsArrayKeyOrCallableNegativeTest($arg1) { expectsArrayKeyOrCallable($arg1); }
        $this->assertNull(deprecatedExpectsArrayKeyOrCallableNegativeTest(2.0));
    }

    public function testDeprecatedExpectsBoolOrCallable_Positive()
    {
        function deprecatedExpectsBoolOrCallablePositiveTest($arg1) { expectsBoolOrCallable($arg1); }
        $this->assertNull(deprecatedExpectsBoolOrCallablePositiveTest(true));
        $this->assertNull(deprecatedExpectsBoolOrCallablePositiveTest(function() { return 'answer 42'; }));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsBoolOrCallableNegativeTest() must be boolean or callable, double 2 given
     */
    public function testDeprecatedExpectsBoolOrCallable_Negative()
    {
        function deprecatedExpectsBoolOrCallableNegativeTest($arg1) { expectsBoolOrCallable($arg1); }
        $this->assertNull(deprecatedExpectsBoolOrCallableNegativeTest(2.0));
    }

    public function testDeprecatedExpectWithMethod_Positive()
    {
        function deprecatedExpectsWithMethodPositiveTest($arg1) { expectsWithMethod($arg1, 'testMethod1'); }
        $this->assertNull(deprecatedExpectsWithMethodPositiveTest(new TestClass()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsWithMethodNegativeTest() must be an object with public method "test_Method_1", NsplTest\TestClass given
     */
    public function testDeprecatedExpectWithMethod_Negative()
    {
        function deprecatedExpectsWithMethodNegativeTest($arg1) { expectsWithMethod($arg1, 'test_Method_1'); }
        $this->assertNull(deprecatedExpectsWithMethodNegativeTest(new TestClass()));
    }

    public function testDeprecatedExpectWithMethods_Positive()
    {
        function deprecatedExpectsWithMethodsPositiveTest($arg1) { expectsWithMethods($arg1, ['testMethod1', 'testMethod2']); }
        $this->assertNull(deprecatedExpectsWithMethodsPositiveTest(new TestClass()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsWithMethodsNegativeTest() must be an object with public methods "testMethod1", "test_Method_2", NsplTest\TestClass given
     */
    public function testDeprecatedExpectWithMethods_Negative()
    {
        function deprecatedExpectsWithMethodsNegativeTest($arg1) { expectsWithMethods($arg1, ['testMethod1', 'test_Method_2']); }
        $this->assertNull(deprecatedExpectsWithMethodsNegativeTest(new TestClass()));
    }

    public function testDeprecatedExpectWithKeys_Positive()
    {
        function deprecatedExpectsWithKeysPositiveTest($arg1) { expectsWithKeys($arg1, ['hello', 'answer']); }
        $this->assertNull(deprecatedExpectsWithKeysPositiveTest(array(
            'hello' => 'world',
            'answer' => 42,
        )));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsWithKeysNegativeTest() must be an array with keys "hello", "answer"
     */
    public function testDeprecatedExpectWithKeys_Negative()
    {
        function deprecatedExpectsWithKeysNegativeTest($arg1) { expectsWithKeys($arg1, ['hello', 'answer']); }
        $this->assertNull(deprecatedExpectsWithKeysNegativeTest(array('hello' => 'world')));
    }

    public function testDeprecatedExpects_Positive()
    {
        function deprecatedExpectsPositiveTest($arg1)
        {
            expects($arg1, 'to be a positive integer', function($arg) {
                return is_int($arg) && $arg > 0;
            });
        }

        $this->assertNull(deprecatedExpectsPositiveTest(42));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\deprecatedExpectsNegativeTest() has to be a positive integer, integer -1 given
     */
    public function testDeprecatedExpects_Negative()
    {
        function deprecatedExpectsNegativeTest($arg1)
        {
            expects($arg1, 'a positive integer', function($arg) {
                return is_int($arg) && $arg > 0;
            });
        }

        $this->assertNull(deprecatedExpectsNegativeTest(-1));
    }

    /**
     * @expectedException \BadFunctionCallException
     * @expectedExceptionMessage Function NsplTest\deprecatedExpectsWithCustomExceptionTest() does not like the given input
     */
    public function testDeprecatedExpectsWithCustomException()
    {
        function deprecatedExpectsWithCustomExceptionTest($arg1)
        {
            expectsBool($arg1, 1, new \BadFunctionCallException(
                'Function NsplTest\deprecatedExpectsWithCustomExceptionTest() does not like the given input'
            ));
        }

        $this->assertNull(deprecatedExpectsWithCustomExceptionTest('true'));
    }

    public function testExpectsCustom_Positive()
    {
        function expectsCustomPositiveTest($arg1)
        {
            expectsToBe($arg1, 'to be a positive integer', function($arg) {
                return is_int($arg) && $arg > 0;
            });
        }

        $this->assertNull(expectsCustomPositiveTest(42));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1 passed to NsplTest\expectsCustomNegativeTest() has to be a positive integer, integer -1 given
     */
    public function testExpectsCustom_Negative()
    {
        function expectsCustomNegativeTest($arg1)
        {
            expectsToBe($arg1, 'a positive integer', function($arg) {
                return is_int($arg) && $arg > 0;
            });
        }

        $this->assertNull(expectsCustomNegativeTest(-1));
    }
    #endregion

}

#region Helpers
class TestClass
{
    public function testMethod1() {}
    public function testMethod2() {}

}

class TestClass2
{
    public function testMethod1() {}
    public function testMethod2() {}

}

function validYear($arg)
{
    return is_int($arg) && $arg > 1900 && $arg <= (int) date('Y');
}
const validYear = '\NsplTest\validYear';
#endregion
